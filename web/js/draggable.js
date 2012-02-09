$('document').ready(init);

function init(){
  $('.room .unit > .task').bind('dragstart', function(event) {
      event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
  });

  // bind the dragover event on the board sections
  $('.room li.unit').bind('dragover', function(event) {
      event.preventDefault();
  });

  // bind the drop event on the board sections
  $('.room li.unit').bind('drop', function(event) {
    if(event.target.nodeName != 'LI') {
      event.preventDefault();
      return false;
    }
    var notecard = event.originalEvent.dataTransfer.getData("text/plain");
    event.target.appendChild(document.getElementById(notecard));
    // Turn off the default behaviour
    // without this, FF will try and go to a URL with your id's name
    event.preventDefault();
  });
}
