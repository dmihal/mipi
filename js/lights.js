$(function(){
  var lights = [];
  window.lights = lights;
  var changeAll = false;

  $.ajax({
    url: 'http://192.168.1.218/api/3fb4730a7fe0697fa0b376570b9b3',
    success: function(data){
      $("#status").text('Connected!');
      for (var i in data.lights) {
        var light = data.lights[i];
        var config  = {id: parseInt(i), name: light.name};
        var rc =  /Row ([0-9]+) (Right|Left|Center)/.exec(light.name);
        config.row = parseInt(rc && rc[1]) || 0;
        config.col = side2col(rc && rc[2]);
        config.color = light.state.on ? 
          fabric.Color.fromHsl("hsl("+~~(light.state.hue*0.00549324788)+","+~~(light.state.sat*0.390625)+"%,"+~~(light.state.bri*0.390625)+"%)") :
          new fabric.Color('000000');
        var newLight = new Light(config);
        lights.push(newLight);
        addLight(newLight);
      };
    },
    failure: function(){
      $("#status").text('Could not connect. Are you on the pizeta network?');
    }
  });
  var canvas = new fabric.Canvas('room');
  canvas.backgroundColor = 'rgb(100,100,255)';

  function addLight(light){
    var circle = new fabric.Circle({ radius: 15, fill: light.color.toRgb()});
    circle.top = light.row * 50 + 20;
    circle.left = light.col * 70 +10;
    circle.hasControls = false;
    circle.lockMovementY = true;
    circle.lockMovementX = true;
    circle.lockScalingY  = true;
    circle.lockScalingX  = true;
    circle.light = light;
    canvas.add(circle);
    light.icon = circle;
  }
  function Light(config){
    this.id  = config.id;
    this.name = config.name;
    this.row = config.row || 0;
    this.col = config.col || 0;
    this.color = config.color;
    this.setColor = function(color,silent){
      this.color = color;
      if(this.icon){
        this.icon.fill = color.toRgb();
        canvas.renderAll();
      }
      if(!silent){
        var e = this.color.getSource(), hsl = this.color._rgbToHsl(e[0], e[1], e[2]);
        var payload = {"on":true, "bri":~~(hsl[2]*2.54), "hue":(hsl[0]*182),"sat":~~(hsl[1]*2.54)};
        $.ajax({
          url: '//192.168.1.218/api/3fb4730a7fe0697fa0b376570b9b3/lights/'+this.id+'/state',
          method: 'PUT',
          data: JSON.stringify(payload)
        });
      }
    };
  }
  function side2col(side){
    switch(side){
    case 'Left':
      return 1;
    case 'Center':
      return 2;
    case 'Right':
      return 3;
    default:
      return 0;
    }
  }
  function getSelectedLights () {
    if (canvas.getActiveGroup()){
      return canvas.getActiveGroup()._objects;
    } else {
      return [canvas.getActiveObject()];
    }
  }
  $("#colorpresets button").click(function(){
    var color = new fabric.Color(this.style.backgroundColor);
    var end = $('#groups :checked').val()==='selected' ? 'lights/'+this.id+'/state' : 'groups/0/action';
    if($('#groups :checked').val()==='selected'){
      var selected = getSelectedLights();
      for (var i = selected.length - 1; i >= 0; i--) {
        selected[i].light.setColor(color);
      };
    } else {
      var e = color.getSource(), hsl = color._rgbToHsl(e[0], e[1], e[2]);
      var payload = {"on":true, "bri":~~(hsl[2]*2.54), "hue":(hsl[0]*182),"sat":~~(hsl[1]*2.54)};
      $.ajax({
        url: '//192.168.1.218/api/3fb4730a7fe0697fa0b376570b9b3/groups/'+$('#groups :checked').val()+'/action',
        method: 'PUT',
        data: JSON.stringify(payload)
      });
      for (var i=0; i < lights.length; i++) {
        lights[i].setColor(color,true);
      };
    }
  });
  $("#btnSelected").click(function(){});
  $("#btnAll").click();
});
