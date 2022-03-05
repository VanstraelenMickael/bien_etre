$(function () {
  // fonction permettant d'ouvrir et fermer le panneau de recherche;
  let rotate = 180;
  $("#titre_recherche").click(function (e) {
    $("#recherche_content").toggleClass("wrapper_content_close");
    $(".icon").css("transform", "rotate(" + rotate + "deg)");
    if (rotate === 0) {
      rotate = 180;
    } else {
      rotate = 0;
    }
  });

  if ($("#recherche_content").hasClass("wrapper_content_close")) {
    $(".icon").css("transform", "rotate(" + rotate + "deg)");
    if (rotate === 0) {
      rotate = 180;
    } else {
      rotate = 0;
    }
  }

  // fonction permettant d'ouvrir et fermer le menu hamburger
  $(".hamburger").click(function (e) {
    let ham = document.querySelector(".hamburger");
    // Si l'hamburger à la classe closed je lui enlève et ajoute opened
    if (ham.classList == "hamburger closed") {
      $(".hamburger").removeClass("closed").addClass("opened");
      // Cas où j'ouvre le menu
      $("aside").css("width", "100%");
      $("aside").css("height", "100%");
      $("aside").css("right", "0%");
    }
    // Je fais l'inverse
    else {
      $(".hamburger").removeClass("opened").addClass("closed");
      // Cas où je ferme le menu
      $("aside").css("right", "-100%");
      $("aside").css("width", "0%");
      $("aside").css("height", "unset");
    }
  });

  // Fonction permettant le chargement de page avec le menu select
  let select = $("#category_select");
  select.on("change", function (e) {
    let selected = $("#category_select option:selected");
    let id = selected.val();
    window.location.replace("../services/" + id);
  });

  // Permet de choisir d'afficher le formulaire Prestataire ou Internaute
  let prestataireForm = $(".formPrestataire");
  let internauteForm = $(".formInternaute");
  let choices = document.querySelectorAll(".choixRole div");
  if (choices) {
    for (let choice of choices) {
      choice.addEventListener("click", () => {
        for (let c of choices) {
          c.classList = "col-12 col-lg-5 col-xl-5";
        }
        choice.classList = "selected col-12 col-lg-5 col-xl-5";
        let choiceName = choice.getAttribute("id");

        switch (choiceName) {
          case "prestataire":
            prestataireForm.addClass("displayed");
            internauteForm.removeClass("displayed");
            break;
          case "internaute":
            internauteForm.addClass("displayed");
            prestataireForm.removeClass("displayed");
            break;
        }
      });
    }
  }
});
