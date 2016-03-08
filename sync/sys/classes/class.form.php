<?php
class Form{
	private $FormName;
	private $requiredControls;
	private $FormHtml;
	private $Method;
	// Construct
	public function __construct(){
		$this->FormName = rand();
		$this->Method = 'POST';
		
		$this->requiredControls = array();
		$this->FormHtml = '';
	}
	
	public function setValidationControls($contoller){
		$this->requiredControls = $contoller;	
	}
	
	public function Reset(){
		self::__construct();	
	}
	
	private function _attributes_to_string($attributes){
		$html = '';
		$abortList = array('name','id','value','type','class');
		if(is_object($attributes) && count($attributes)>0):
			$attributes = (array)$attributes;
		endif;
		if(is_array($attributes) && count($attributes)):
			foreach($attributes as $key=>$value):
				if(!in_array($key,$abortList)){
					$html .= ' '.$key.'="'.$value.'"';
				}
			endforeach;
		endif;
		return $html;
	}
	
	private function getValue($key){
		switch($this->Method){
			case 'POST':
					return isset($_POST[$key])?$_POST[$key]:false;
				break;
			case 'GET':
					return isset($_GET[$key])?$_GET[$key]:false;
				break;
			case 'PUT':
					return false;
				break;
			case 'DELETE':
					return false;
				break;
		}	
	}
	public function setMethod($Method){
		$AllowMethod = array('POST','GET','PUT','DELETE');
		if(in_array($Method,$AllowMethod)){
			$this->Method = strtoupper($Method);
			return true;
		}else{
			$this->Method = 'POST';
			return false;	
		}
	}
	
	public function setForm($content = ''){
		$this->FormHtml = $content;
	}
	public function getForm(){
		return $this->FormHtml;
	}
	
	public function Open($action = '' , $name = false ,$class = '', $attributes = array()){
		$this->FormName = $name?$name:$this->FormName;
		$html = '';
		$html = '<form name="'.$this->FormName.'" id="'.$this->FormName.'" action="'.$action.'"  class="'.$class.'" method="'.$this->Method.'"';
		$html .= $this->_attributes_to_string($attributes);
		$html .= '>';
		$this->FormHtml .= $html; 
		
		return $html;
	}
	public function Close(){
		$html = '</form>';
		$this->FormHtml .= $html;
		
		return $html;	
	}
	
	// Form Validataion 
	private function validateControl($value,$validateType = 'text',$label = 'This Filed'){
		$errorMessage = '';
		$validateType = $validateType==''?'text':$validateType;
		switch($validateType):
			case 'text':
			case 'password':
					if( empty($value) || (! isset($value))):
						$errorMessage = 'Please Fill '.$label.'';
					endif;
				break;
			case 'email':
					if(empty($value) || (! isset($value))):
						$errorMessage = 'Please Fill '.$label.'';
					elseif(!filter_var($value, FILTER_VALIDATE_EMAIL)):
						$errorMessage = "Invalid Email Format";
					endif;
				break;
			case 'tel':
					if(empty($value) || (! isset($value))):
						$errorMessage = 'Please Fill '.$label.'';
					elseif((!is_numeric($value)) ):
						$errorMessage = "Telephone Must be Numeric";
					elseif(! preg_match("/^[0-9]{7,15}$/", $value)):
						$errorMessage = 'Invalid Format';
					endif;
				break;
			case 'number':
					if(empty($value) || (! isset($value))):
						$errorMessage = 'Please Fill '.$label.'';
					elseif((!is_numeric($value)) ):
						$errorMessage = "Field Must be Numeric";
					endif;
					break;
			case 'date':
					$d = date_parse_from_format("m-d-Y", $value);
					//DisplayObject($d);
					if(empty($value) || (! isset($value))):
						$errorMessage = 'Please Fill '.$label.'';
					elseif(!checkdate($d['month'],$d['day'],$d['year'])):
						$errorMessage = 'Invalid Format (Valid Formate : MM/DD/YYYY) ';
					endif;
				break;
			case 'radio':
			case 'checkbox':
					if(is_array($value) && count($value)<=0):
						$errorMessage = 'Please Fill '.$label.'';
					endif;
				break;
			case 'url':
					$value = filter_var($value, FILTER_SANITIZE_URL);
					if(empty($value) || (! isset($value))):
						$errorMessage = 'Please Fill '.$label.'';
					elseif(!filter_var($value, FILTER_VALIDATE_URL)):
						$errorMessage = "Invalid Url Format";
					endif;
				break;
			case 'file':
					if(empty($value) || (! isset($value))):
						$errorMessage = 'Please Fill '.$label.'';
					endif;
				break;
		endswitch;
		
		return $errorMessage;
	}
	/*public function Validate( ){
		$controls = $this->requiredControls;
		if(!(isset($controls))):
			return false;	
		endif;
		if(is_object($controls) && count($controls)>0):
			$controls = (array)$controls;
		endif;
		if(is_array($controls) && count($controls)>0):
			foreach($controls as $control):
				if(is_object($control)):
					$control = (array)$control;
				endif;
				//$type = isset($control[1])?$control[1]:'text';
				
				if($control[1] != 'file' ):
					if($this->getValue($control[0])):
						if((!$this->validateControl($$this->getValue($control[0]),$control[1]) == '') || (! is_array($control)) ):
							return false;
						endif;
					else:
						return false;
					endif;
				elseif($control[1] == 'file'):
					if(isset($_FILES[$control[0]])):
						if((!$this->validateControl($_FILES[$control[0]]['name'],$control[1]) == '') || (! is_array($control)) ):
							return false;
						endif;
					else:
						return false;
					endif;
					
				else: // If Control is not set
					return false;
				endif;
			endforeach;
		endif;
		return true;
	}*/
	
	public function Validate($controls){
		
		if(is_object($controls) && count($controls)>0):
			$controls = (array)$controls;
		endif;
		if(is_array($controls) && count($controls)>0):
			foreach($controls as $control):
				if(is_object($control)):
					$control = (array)$control;
				endif;
				//$type = isset($control[1])?$control[1]:'text';
				
				if($control[1] != 'file' ):
					if($this->getValue($control[0])):
						if( (!$this->validateControl( $this->getValue($control[0]),$control[1] ) == '') || (! is_array($control)) ):
							return false;
						endif;
					else:
						return false;
					endif;
				elseif($control[1] == 'file'):
					if(isset($_FILES[$control[0]])):
						if((!$this->validateControl($_FILES[$control[0]]['name'],$control[1]) == '') || (! is_array($control)) ):
							return false;
						endif;
					else:
						return false;
					endif;
				else: // If Control is not set
					return false;
				endif;
			endforeach;
		endif;
		return true;
	}
	
	// Controllers FUnction 
	public function Input($type = 'text', $name = '',$value='', $class = '', $label = false, $attributes = array(),  $htmlAttr = array(), $serverAttr = array()){
		// if Type is not set then 'Text' will default
		$type = $type==''?'text':$type;
		$isTime = $type=='time'?true:false;
		
		// is Maintaine state
		if(!(isset($serverAttr['maintain_state']) && $serverAttr['maintain_state'] ==false )  ):
			$value = $this->getValue($name)?$this->getValue($name):$value;
		endif;

		$html = '';
		$html = '<div class="form-group">';// wrapper
			if($label):
				$html .= isset($htmlAttr['before_label'])?$htmlAttr['before_label']:''; // Label Wrapper
					$html .= '<label class="control-label" for="'.$name.'" class="control-label">'.$label.'</label>';
				$html .= isset($htmlAttr['after_label'])?$htmlAttr['after_label']:'';
			endif; // Label Wrapper Over
			
			$html .= isset($htmlAttr['before_control'])?$htmlAttr['before_control']:''; // Controller Wrapper 
				
				$html .= $isTime?'<div class="bootstrap-timepicker">':''; // Timer wrapper
				
				$isRequired =  (!(isset($serverAttr['required']) && $serverAttr['required'] ==false))?'required':'';
					$html .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'" '.$isRequired.'  class="form-control '.$class.'"';
					$html .= $this->_attributes_to_string($attributes);
					$html .= " value='".$value."' >";
				
				$html .= $isTime?'</div>':''; // Timer wrapper Over
				
				if(count($_POST)>0 && (!(isset($serverAttr['required']) && $serverAttr['required'] ==false))){
					//$this->requiredControls[] = array($name,$type);
					$html .= '<p class="text-danger">'.$this->validateControl($value,$type).'</p>'; // Controller Message
				}
				
			$html .= isset($htmlAttr['after_control'])?$htmlAttr['after_control']:'';// Controller Wrapper Over
			
		$html .= '</div>'; // wrapper Over
		
		$this->FormHtml .= $html;
		return $html;
	}
	
	
	public function Textarea( $name = '',$value='', $class = '',$label =false, $attributes = array(),  $htmlAttr = array(), $dataAttr = array()){
		if(!(isset($dataAttr['maintain_state']) && $dataAttr['maintain_state'] ==false) ):
			$value = $this->getValue($name)?$this->getValue($name):$value;
		endif;
		$html = '';
		$html = '<div class="form-group">';
			if($label):
				$html .= isset($htmlAttr['before_label'])?$htmlAttr['before_label']:'';
					$html .= '<label class="control-label" for="'.$name.'">'.$label.'</label>';
				$html .= isset($htmlAttr['after_label'])?$htmlAttr['after_label']:'';
			endif;
			$html .= isset($htmlAttr['before_control'])?$htmlAttr['before_control']:'';
			$isRequired =  (!(isset($dataAttr['required']) && $dataAttr['required'] ==false))?'required':'';
				$html .= '<textarea name="'.$name.'" id="'.$name.'" class="form-control '.$class.'" '.$isRequired.'';
				$html .= $this->_attributes_to_string($attributes);
				$html .= ' >'.$value.'</textarea>';
				if(count($_POST)>0 && (!(isset($dataAttr['required']) && $dataAttr['required'] ==false)) ){
					$html .= '<p class="text-danger">'.$this->validateControl($value).'</p>';
				}
			$html .= isset($htmlAttr['after_control'])?$htmlAttr['after_control']:'';
		$html .= '</div>';
		return $html;
		
	}
	
	//	Form Drop Down
	//	@param 1 = name
	//	@param 2 = value
	//	@param 3 = class
	//	@param 4 = $label
	//	@param 5 = Attributes [array]
	//	@param 6 = Html Attributes [array]
	//	@param 7 = Data Attributes [array]
	//	$DrpRoll = array(
	//			'type' => 'resource', 'array' OR 'object'
	//			'contant' => array(
	//				'resource' => $DrpResource,
	//				'value_field' => 'RoleId',
	//				'label_field' => 'RoleName'
	//			)
	//		);
	//	$DrpRoll = array(
	//			''type' => 'array',
	//					'contant' =>	array(
	//					 				1 => 'Push Notification',
	//									2 => 'Mail Notfication',
	//						 		),
	//		);
	//	@param 8 = Server Attribure [array]  array('maintain_state'=>true/false, 'multiple' => true/false, 'required' => true/false );
	
	function Dropdown($name = '',$value='', $class = '', $label = false, $attributes = array(),  $htmlAttr = array(), $dataAttr = array(),$serverAttr=array()){
		if(!(isset($serverAttr['maintain_state']) && $serverAttr['maintain_state'] ==false) ):
			$value = $this->getValue($name)?$this->getValue($name):$value;
		endif;
		
		$isRequired =  (!(isset($serverAttr['required']) && $serverAttr['required'] ==false))?'required':'';
		$isMultiple = isset($serverAttr['multiple'])&&$serverAttr['multiple']==true?true:false;
		
		$name = $isMultiple?$name.'[]':$name;				
		
		$html = '';
		$html = '<div class="form-group">';
			if($label):
				$html .= isset($htmlAttr['before_label'])?$htmlAttr['before_label']:'';
					$html .= '<label class="control-label" for="'.$name.'">'.$label.'</label>';
				$html .= isset($htmlAttr['after_label'])?$htmlAttr['after_label']:'';
			endif;
			
			$html .= isset($htmlAttr['before_control'])?$htmlAttr['before_control']:'';
				$multiple = $isMultiple?'multiple':'';
				$html .= '<select id="'.$name.'" name="'.$name.'" '.$isRequired.' class="form-control '.$class.'" '.$multiple.' ';
				$html .= $this->_attributes_to_string($attributes).' >';
				if($isMultiple):
					$html.= '<option disabled>Please Select</option>';	
				else:
					$html.= '<option selected disabled>Please Select</option>';	
				endif;
				
					if(isset($dataAttr['type'])):
					
						switch($dataAttr['type']):
							case 'resource':
									if(gettype($dataAttr['contant']['resource']) == 'resource'):
										while($row = mysql_fetch_assoc($dataAttr['contant']['resource'])):
										$hiddenValue = isset($dataAttr['contant']['hidden_field'])?'data-hidden="'.$row[$dataAttr['contant']['hidden_field']].'"':'';
											//if($isMultiple):
											
											//else:
												if($row[$dataAttr['contant']['value_field']] == $value || ($isMultiple && is_array($value) && in_array($row[$dataAttr['contant']['value_field']],$value))):
													$html .= '<option selected '.$hiddenValue.' value="'.$row[$dataAttr['contant']['value_field']].'">'.$row[$dataAttr['contant']['label_field']].'</option>';
												else:
													$html .= '<option '.$hiddenValue.' value="'.$row[$dataAttr['contant']['value_field']].'">'.$row[$dataAttr['contant']['label_field']].'</option>';	
												endif;
											//endif;
										endwhile;
									endif;
								break;
							case 'object':
								if( is_object( $dataAttr['contant'])):
									$dataAttr['contant'] = (array)$dataAttr['contant'];
								endif;
								// Do not user Break here
							case 'array':
								foreach($dataAttr['contant'] as $val=>$label):
									if($val == $value  || ($isMultiple && is_array($value) && in_array($val,$value))):
										$html .= '<option value="'.$val.'" selected >'.$label.'</option>';
									else:
										$html .= '<option value="'.$val.'" >'.$label.'</option>';
									endif;
								endforeach;
								break;
							default:
								$html .= '<option disabled >Please Select Contant Type</option>';
								break;
						endswitch;
					else:
						$html .= '<option disabled >Please Select Contant Type</option>';
					endif;
				$html .= '</select>';
				if(count($_POST)>0 && (!(isset($serverAttr['required']) && $serverAttr['required'] ==false))){
					//$this->requiredControls[] = array($name,'text');
					$html .= '<p class="clear text-danger">'.$this->validateControl($value).'</p>';
				}
			$html .= isset($htmlAttr['after_control'])?$htmlAttr['after_control']:'';
		$html .= '</div>';
		
		$this->FormHtml .= $html;
		return $html;	
	}
	
	
	// Cehck Box
	public function Checkbox($name,$value = array(),$class='',$label = false, $htmlAttr= array(), $elements = array(),$dataAttr=array()){
		//alert($class);
		if(!(isset($dataAttr['maintain_state']) && $dataAttr['maintain_state'] ==false) ):
			$value = $this->getValue($name)?$this->getValue($name):$value;
		endif;
		$html = '';	
		$html = '<div class="form-group">';
			if($label):
				$html .= isset($htmlAttr['before_label'])?$htmlAttr['before_label']:'';
					$html .= '<label class="control-label" for="'.$name.'">'.$label.'</label>';
				$html .= isset($htmlAttr['after_label'])?$htmlAttr['after_label']:'';
			endif;
			$html .= isset($htmlAttr['before_control'])?$htmlAttr['before_control']:'';
				foreach($elements as $key=>$cbxlabel):
					$isChecked = in_array($key,$value)?'checked="true"':'';
					$html .= '<label class="cbx-label">';	
						$html .= '<input type="checkbox" class="'.$class.'" name="'.$name.'['.$key.']" id="'.$name.'['.$key.']" '.$isChecked.' value="'.$key.'"><span>'.$cbxlabel.'</span>';
					$html .= '</label>';
				endforeach;
				if(count($_POST)>0	&& (!(isset($dataAttr['required']) && $dataAttr['required'] ==false)) ){
					$html .= '<p class="text-danger">'.$this->validateControl($value,'checkbox').'</p>';
				}
			$html .= isset($htmlAttr['after_control'])?$htmlAttr['after_control']:'';
		$html .= '</div>';
		return $html;
	}
	
	
	// Radio Button
	public function Radio($name,$value = array(),$class='',$label = false, $htmlAttr= array(), $elements = array(),$dataAttr=array()){
		//alert($class);
		if(!(isset($dataAttr['maintain_state']) && $dataAttr['maintain_state'] ==false) ):
			$value = $this->getValue($name)?$this->getValue($name):$value;
		endif;
		$html = '';	
		$html = '<div class="form-group">';
			if($label):
				$html .= isset($htmlAttr['before_label'])?$htmlAttr['before_label']:'';
					$html .= '<label class="control-label" for="'.$name.'">'.$label.'</label>';
				$html .= isset($htmlAttr['after_label'])?$htmlAttr['after_label']:'';
			endif;
			$html .= isset($htmlAttr['before_control'])?$htmlAttr['before_control']:'';
				foreach($elements as $key=>$cbxlabel):
					$isChecked = $key==$value?'checked="true"':'';
					$html .= '<label class="cbx-label">';	
						$html .= '<input type="radio" class="'.$class.'" name="'.$name.'" id="'.$name.'" '.$isChecked.' value="'.$key.'"><span>'.$cbxlabel.'</span>';
					$html .= '</label>';
				endforeach;
				if(count($_POST)>0	&& (!(isset($dataAttr['required']) && $dataAttr['required'] ==false)) ){
					$html .= '<p class="text-danger">'.$this->validateControl($value,'radio').'</p>';
				}
			$html .= isset($htmlAttr['after_control'])?$htmlAttr['after_control']:'';
		$html .= '</div>';
		return $html;
	}
	
	
	// Button
	public function Button($type = 'submit', $name = '', $value = 'Submit', $class = '', $attributes = array(), $htmlAttr = array()){
		$type = $type==''?'submit':$type;
		$html = '';
		$html = isset($htmlAttr['before_control'])?$htmlAttr['before_control']:''; // Controller Wrapper 
			$html .= '<button type="'.$type.'" id="'. $name.'" name="'.$name.'" class="btn '.$class.'" data-form="'.$this->FormName.'" value="'.$value.'"';
			$html .= $this->_attributes_to_string($attributes);
			$html .= '>'.$value.'</button>';
		$html .= isset($htmlAttr['after_control'])?$htmlAttr['after_control']:'';// Controller Wrapper Over
		
		$this->FormHtml .= $html;
		return $html;
	}
	
}