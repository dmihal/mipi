<?php
$page = new Page("Family Tree");
$page->section = "members";

ob_start();
?>
$(function(){
    var width = 960,
        height = 300;
    
    var cluster = d3.layout.cluster()
        .size([height, width - 160]);
    
    var diagonal = d3.svg.diagonal()
        .projection(function(d) { return [d.y, d.x]; });
    
    var vis = d3.select("#tree").append("svg")
        .attr("width", width)
        .attr("height", height)
      .append("g")
        .attr("transform", "translate(40, 0)");
    
    d3.json("/members/getTree", function(json) {
      var nodes = cluster.nodes(json);
    
      var link = vis.selectAll("path.link")
          .data(cluster.links(nodes))
        .enter().append("path")
          .attr("class", "link")
          .attr("d", diagonal);
    
      var node = vis.selectAll("g.node")
          .data(nodes)
        .enter().append("g")
          .attr("class", "node")
          .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
    
      node.append("circle")
          .attr("r", 4.5);
    
      node.append("text")
          .attr("dx", function(d) { return d.children ? -8 : 8; })
          .attr("dy", 3)
          .attr("text-anchor", function(d) { return d.children ? "end" : "start"; })
          .text(function(d) { return d.name; });
    });
});
<?php
$page->js  = ob_get_clean();

$box = new Box("tree","Family Tree");
//$tree = Member::buildTree();
$box->setContent(new BCStatic('<link href="http://mbostock.github.com/d3/ex/cluster.css" rel="stylesheet" /><div id="tree"></div>'));
$page->addBox($box,'tripple');


return $page;
?>