function adicionarSetor() {
  var secretaria = $("#secretaria").val();
  var nomeSetor = $("input[name='nome_setor']").val();

  $.ajax({
    url: "processa_setores.php",
    type: "POST",
    dataType: "json",
    data: {
      secretaria: secretaria,
      nome_setor: nomeSetor
    },
    success: function (response) {
      $("input[name='nome_setor']").val('');

      var toastMessage = response.message;

      if (response.status === "success") {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
        $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
        $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

        buscarSetores();
      } else if (response.status === "warning") {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Campo em branco");
        $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-success").addClass("bg-warning");
        $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-x").addClass("bx-edit-alt");
      } else {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
        $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
        $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
      }

      $(".toast-placement-ex .toast-body").text(toastMessage);

      $("#showToastPlacement").click();
    },
    error: function (xhr, status, error) {
      console.log('Erro ao adicionar secretaria: ' + error);
    }
  });
}

function buscarSetores() {
  var secretaria = $('#secretaria').val();

  $.ajax({
    type: 'POST',
    url: 'buscar_setores.php',
    data: {
      secretaria: secretaria
    },
    dataType: 'json',
    success: function (response) {
      
      $('#setores_existentes').html('');

      if (response.length > 0) {
        $('#exists').show();

        var opcoesHTML = '<div class="mb-1">';
        for (var i = 0; i < response.length; i++) {
          opcoesHTML += '<div class="card card-setor">';
          opcoesHTML += '<span style="padding: 10px;">' + response[i] + '</span>';
          opcoesHTML += '<button type="button" class="btn btn-icon btn-renomear-setor" data-bs-toggle="modal" data-bs-target="#modalCenterRenomear"><i class="bx bxs-edit-alt"></i></button>';
          opcoesHTML += '<button type="button" class="btn btn-icon btn-excluir-setor" data-bs-toggle="modal" data-bs-target="#modalCenter"><i class="bx bx-x"></i></button>';
          opcoesHTML += '</div>';
        }
        opcoesHTML += '</div>';
        $('#setores_existentes').html(opcoesHTML);
      } else {
        // Se não houver resposta, ocultar a div com a classe "row"
        $('#exists').hide();
      }
    },
    error: function (error) {
      console.log("Erro na solicitação AJAX: ", error);
    }
  });
}

// Adicione a lógica para excluir o setor quando o modal é mostrado
$('#modalCenter').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Botão que acionou o modal
  var nomeSetor = button.siblings('span').text(); // Texto do setor associado ao botão
  var modal = $(this);

  // Define o título do modal como o nome do setor
  modal.find('.modal-title').text(nomeSetor);

  // Atribui a função excluirSetor() ao botão "Excluir" do modal
  modal.find('.btn-danger').off('click').on('click', function () {
    excluirOpcao(nomeSetor);
    modal.modal('hide'); // Fecha o modal após excluir o setor
  });
});


// Adicione a lógica para renomear o setor quando o modal é mostrado
$('#modalCenterRenomear').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Botão que acionou o modal
  var nomeSetor = button.siblings('span').text(); // Texto do setor associado ao botão
  var modal = $(this);

  // Define o título do modal como o nome do setor
  modal.find('.modal-title').text(nomeSetor);

  // Atribui a função renomearOpcao() ao botão "Renomear" do modal
  modal.find('.btn-warning').off('click').on('click', function () {
    // Obter o novo nome do setor digitado no input
    var novoNomeSetor = modal.find('#nameWithTitle').val();
    // Chama a função renomearOpcao() com o novo nome do setor
    renomearOpcao(nomeSetor, novoNomeSetor);
    modal.modal('hide'); // Fecha o modal após renomear o setor
  });
});

function renomearOpcao(nomeSetor, novoNomeSetor) {  
  var secretaria = $("#secretaria").val();

  $.ajax({
    url: 'renomear_setor.php',
    method: 'POST',
    data: {
      secretaria: secretaria,
      setor: nomeSetor,
      novoNome: novoNomeSetor
    },
    dataType: 'json',
    success: function (response) {
      var toastMessage = response.message;

      if (response.status === "success") {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
        $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
        $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

        buscarSetores();
      } else {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
        $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
        $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
      }

      $(".toast-placement-ex .toast-body").text(toastMessage);

      $("#showToastPlacement").click();
    },
    error: function (error) {
      console.log("Erro na solicitação AJAX: ", error);
    }
  })
}

function excluirOpcao(index) {  
  $.ajax({
    url: 'excluir_setor.php',
    method: 'POST',
    data: {
      setor : index
    },
    dataType: 'json',
    success: function (response) {
      var toastMessage = response.message;

      if (response.status === "success") {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
        $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
        $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

        buscarSetores();
      } else {
        $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
        $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
        $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
      }

      $(".toast-placement-ex .toast-body").text(toastMessage);

      $("#showToastPlacement").click();
    },
    error: function (error) {
      console.log("Erro na solicitação AJAX: ", error);
    }
  })
}




/**
 * UI Toasts
 */

'use strict';

(function () {
  // Bootstrap toasts example
  // --------------------------------------------------------------------
  const toastPlacementExample = document.querySelector('.toast-placement-ex'),
    toastPlacementBtn = document.querySelector('#showToastPlacement');
  let toastPlacement;

  // Dispose toast when open another
  function toastDispose(toast) {
    if (toast && toast._element !== null) {
      toast.dispose();
    }
  }
  // Placement Button click
  if (toastPlacementBtn) {
    toastPlacementBtn.onclick = function () {
      if (toastPlacement) {
        toastDispose(toastPlacement);
      }

      toastPlacement = new bootstrap.Toast(toastPlacementExample);
      toastPlacement.show();
    };
  }
})();