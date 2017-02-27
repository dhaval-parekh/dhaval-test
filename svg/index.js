var parse = require('parse-svg-path')
var extract = require('extract-svg-path')

//var path = extract(__dirname + '/files/output.svg')
var path = extract(__dirname + '/files/output-red.svg')
var svg = parse(path)
console.log(svg)