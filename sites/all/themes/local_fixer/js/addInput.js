var counter = 1;
var limit = 3;
function addInput(divName,inputName,cntName){
  counter = jQuery('#'+cntName).val();
  if (counter == limit)  {
    alert("You have reached the limit of adding " + counter + " inputs");
  }
  else {
    var newdiv = document.createElement('div');
    newdiv.innerHTML = "<div class='recom-field-box'><input onblur='javascript:addTick(this)' id='test"+cntName+"' type='text' placeholder='' name='"+inputName+"[]'></div>";
    document.getElementById(divName).appendChild(newdiv);
    counter++;
    jQuery('#'+cntName).val(counter);
  }
}

function addTick(div){
  if(div.value){
    jQuery(div).after('<span><img alt="" src="/sites/all/themes/local_fixer/images/righticon.png"></span>');
  } else {
    jQuery(div).next().remove();
  }
  
}