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

 var deleteOperationModal = document.getElementById('deleteCategoryIncome')
 deleteOperationModal.addEventListener('show.bs.modal', function (event) {
 var button = event.relatedTarget
 var oldName = button.getAttribute('data-bs-whatever')
 var modalBodyInputH = deleteOperationModal.querySelector('.modal-body-H input')
 var modalTitle = deleteOperationModal.querySelector('.text')
 modalBodyInputH.value = oldName
 modalTitle.textContent = oldName
 var selectCategory = deleteOperationModal.querySelector('.form-select')
 for (var i = 0; i < selectCategory.options.length; i++) {
   if (selectCategory.options[i].value === oldName) {
     selectCategory.options[i].setAttribute('disabled', true)
   } else {
     selectCategory.options[i].removeAttribute('disabled')
   }
 }
})

