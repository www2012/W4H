$('document').ready(init);

function init(){
  $('.room .unit > .task').bind('dragstart', function(event) {
      event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
  });

  // bind the dragover event on the unit sections
  $('.room li.unit').bind('dragover', function(event) {
      event.preventDefault();
      $(this).addClass('over');
//      e.dataTransfer.dropEffect = 'copy';
//      return false;
  });
    // bind the dragenter event on the unit sections
  $('.room li.unit').bind('dragenter', function () {
      $(this).addClass('over');
      return false;
  })

  // bind the dragleave event on the unit sections
  $('.room li.unit').bind('dragleave', function () {
     $(this).removeClass('over');
  });

  // bind the drop event on the unit sections
  $('.room li.unit').bind('drop', function(event) {
    if(event.target.nodeName != 'LI') {
      event.preventDefault();
      return false;
    }

    $(this).removeClass('over');

    var notecard = event.originalEvent.dataTransfer.getData("text/plain");
    event.target.appendChild(document.getElementById(notecard));
    // Turn off the default behaviour
    // without this, FF will try and go to a URL with your id's name
    event.preventDefault();
  });
}
