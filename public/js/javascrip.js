(function () {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
  
          form.classList.add('was-validated')
        }, false)
      })
  })()




  var editOperationModal = document.getElementById('editCategoryIncome')
  editOperationModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget
  var oldName = button.getAttribute('data-bs-whatever')
  var modalBodyInput = editOperationModal.querySelector('.modal-body input')
  
  var modalBodyInputH = editOperationModal.querySelector('.modal-body-H input')
  modalBodyInput.value = oldName
  modalBodyInputH.value = oldName





 })

  //var hiddenInput = editOperationModal.querySelector('input[name=oldNameCategory]')
//hiddenInput.value = oldName 


/*
var editOperationModal = document.getElementById('editCategoryIncome');
editOperationModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  var oldName = button.getAttribute('data-bs-whatever');
  var modalBodyInput = editOperationModal.querySelector('.modal-body input[name=newNameCategory]');
  modalBodyInput.value = oldName;
  var hiddenInput = editOperationModal.querySelector('input[name=oldNameCategory]');
  hiddenInput.value = oldName;
  
  var form = editOperationModal.querySelector('form');
  form.addEventListener('submit', function(event) {
    event.preventDefault();
    var newName = modalBodyInput.value;
    // send both oldName and newName to server
    // ...
    // hide the modal after successful submission
    var modal = bootstrap.Modal.getInstance(editOperationModal);
    modal.hide();
  });
});
*/
/*
var editOperationModal = document.getElementById('editCategoryIncome');
editOperationModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  var oldName = button.getAttribute('data-bs-whatever');
  var modalBodyInput = editOperationModal.querySelector('.modal-body input[name=newNameCategory]');
  modalBodyInput.value = oldName;
  var hiddenInput = editOperationModal.querySelector('input[name=oldNameCategory]');
  hiddenInput.value = oldName;

  var form = editOperationModal.querySelector('form');
  form.addEventListener('submit', function(event) {
    event.preventDefault();
    var oldName = editOperationModal.querySelector('input[name=oldNameCategory]').value;
    console.log('Old name:', oldName);
    // add your code to handle the form submission with oldName
    // for example, you can submit the form using AJAX and pass oldName as data
  });
});
*/