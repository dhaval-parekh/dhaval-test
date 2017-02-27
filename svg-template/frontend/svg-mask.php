<html>
    <head>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.js?2.6.0"></script>
    </head>
    <body>
        <svg>
            <defs>
            
            <mask id="rekt">
                <g id="rrr">
                    <rect  width=50 height=50 fill="#ccc"></rect> 
                    <rect  x=50 y=50 width=50 height=50 fill="#ccc"></rect> 
                </g>
            </mask>
            </defs>

            <rect width="100%" height="100%" fill="#cccccc"></rect>
            <rect mask="url(#rekt)" width=100 height=100 x=0 y=0 fill="#00f"transform="translate(20,20)"></rect>
            <rect mask="url(#rekt)" width=100 height=100 x=0 y=0 fill="#00f"transform="translate(20,230)rotate(-90)"></rect>
            <rect mask="url(#rekt)" width=100 height=100 x=0 y=0 fill="#00f"transform="translate(110,120)rotate(-90)"></rect>
            <rect mask="url(#rekt)" width=100 height=100 x=0 y=0 fill="#00f"transform="translate(110,130)"></rect>

            <!--
            you can reuse the masked out rect
            <rect id="maniconinstance" mask="url(#maniconmask)" width=100 height=100 x=0 y=0 fill="#f00"></rect>
            <rect id="womaniconinstance" mask="url(#womaniconmask)" width=100 height=100 x=0 y=0 fill="#f00"></rect>

            <use xlink:href="#maniconinstance" transform="translate(110,0)" width=100 height=100></use>
            <use xlink:href="#womaniconinstance" transform="translate(160,0)" width=100 height=100></use>

            or you can directly use the elements (as long as you are referencing the proper id)
            <use xlink:href="#manicon" transform="translate(200,200)scale(.5,.5)"></use>
            -->
        </svg>

        <script type="text/javascript">
            //Make a mask from an external svg element, then mask a rectangle with it
            function make_icon(url, name, color)
            {
                defs = d3.select("defs")
                d3.html(url, function(data) {
                    console.log("data", data)
                    //get a selection of the image so we can pull out the icon
                    xml = d3.select(data) 
                    console.log("xml", xml.select("#icon"), xml.select("#icon").node())

                    icon = document.importNode(xml.select("#icon").node(), true)
                    console.log("icon", icon)

                    //we make a mask object
                    mask = defs.append("svg:mask")
                        .attr("id", name + "iconmask")
                    icon.id = name + "icon"
                    //this is where the icon gets inserted into the DOM
                    mask.node().appendChild(icon)

                    console.log("mask", mask)
                })
                //masked rectangle 
                defs.append("svg:rect")
                    .attr("id", name + "iconinstance")
                    .attr("width", 50)
                    .attr("height", 100)
                    .attr("mask", "url(#" + name + "iconmask)")
                    .attr("fill", color)
            }

            //add a row of use elements which point to our masked element
            function make_row(name, icon, n, x, y)
            {
                d3.select("svg").selectAll("use." + name)
                    .data(d3.range(n))
                .enter()
                    .append("svg:use")
                    .attr("class", name)
                    .attr("xlink:href", "#" + icon + "iconinstance")
                    .attr("transform", function(d,i) {
                           return "translate(" + [x + 50 * i, y] + ")"
                    })
            }

            
            make_icon("../image/man.svg", "man", "red")
            make_icon("../image/woman.svg", "woman", "white")
           
            make_row("a", "man", 14, 220, 20)
            make_row("b", "woman", 14, 220, 130)
            make_row("c", "man", 18, 20, 240)
            make_row("d", "woman", 18, 20, 350)
        </script>
    </body>
</html>