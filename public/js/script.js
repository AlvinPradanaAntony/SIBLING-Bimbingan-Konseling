/*========== SIDEBAR ACTIVE/DEACTIVATE ==========*/
$(document).ready(function () {
  $("#menu").click(function (e) {
    $("#sidebar").toggleClass("close");
  });
});

/*========== SPINNER ON BUTTON ==========*/
$(document).ready(function() {
  $('#formLogin').submit(function() {
    let btnSubmit = $(this).find('button[type="submit"]');
    let spinner = btnSubmit.find('.spinner-border');
    $('#btnSubmit').prop('disabled', true);
    $('.text_btn').hide();
    spinner.show(); 
  });
});

/*========== COLLAPSE/ACCORDION ==========*/
$(document).ready(function () {
  $(".collapse").on("show.bs.collapse", function () {
    $(".collapse.show").each(function () {
      $(this).collapse("hide");
    });
  });
});
$(document).ready(function () {
  // Tambahkan class ketika collapse di klik
  $(".collapse")
    .on("show.bs.collapse", function () {
      $(this).parent().addClass("nav-item-active");
    })
    .on("hide.bs.collapse", function () {
      $(".nav-item").removeClass("nav-item-active");
    });
});
$(document).ready(function () {});

/*==================== DARK LIGHT THEME ====================*/
$(document).ready(function () {
  var darkMode;

  if (localStorage.getItem("dark-mode")) {
    // if dark mode is in storage, set variable with that value
    darkMode = localStorage.getItem("dark-mode");
  } else {
    // if dark mode is not in storage, set variable to 'light'
    darkMode = "light";
  }

  // set new localStorage value
  localStorage.setItem("dark-mode", darkMode);

  if (localStorage.getItem("dark-mode") == "dark") {
    $("body").addClass("dark-theme");
    $("#dark-dropdownItem").removeClass("uil-moon");
    $("#dark-dropdownItem").addClass("uil-sun");
    $(".nameItem").text("Tema Terang");
    $("#theme-button").removeClass("uil-moon");
    $("#theme-button").addClass("uil-sun");
    $("#logo_sidebar").attr("src", "img/app_logo_extend_w.png");

    if ($("#sidebar").hasClass("close")) {
      $("#logo_sidebar")
        .fadeOut(150, function () {
          $("#logo_sidebar").attr("src", "img/app_logo.png");
          $("#logo_sidebar").attr("width", "40");
        })
        .fadeIn(150);
    } else {
      $("#logo_sidebar")
        .fadeOut(150, function () {
          $("#logo_sidebar").attr("src", "img/app_logo_extend_w.png");
          $("#logo_sidebar").attr("width", "135");
        })
        .fadeIn(150);
    }
  }

  $("#theme-button, #theme-button2").on("click", function () {
    if ($("body").hasClass("dark-theme")) {
      $("#dark-dropdownItem").removeClass("uil-sun");
      $("#dark-dropdownItem").addClass("uil-moon");
      $(".nameItem").text("Tema Gelap");
      $("#theme-button").removeClass("uil-sun");
      $("#theme-button").addClass("uil-moon");
      $("body").removeClass("dark-theme");

      if ($("#sidebar").hasClass("close")) {
        $("#logo_sidebar")
          .fadeOut(150, function () {
            $("#logo_sidebar").attr("src", "img/app_logo.png");
            $("#logo_sidebar").attr("width", "40");
          })
          .fadeIn(150);
      } else {
        $("#logo_sidebar")
          .fadeOut(150, function () {
            $("#logo_sidebar").attr("src", "img/app_logo_extend.png");
            $("#logo_sidebar").attr("width", "135");
          })
          .fadeIn(150);
      }
      // set stored value to 'light'
      localStorage.setItem("dark-mode", "light");
    } else {
      $("#dark-dropdownItem").removeClass("uil-moon");
      $("#dark-dropdownItem").addClass("uil-sun");
      $(".nameItem").text("Tema Terang");
      $("#theme-button").removeClass("uil-moon");
      $("#theme-button").addClass("uil-sun");
      $("body").addClass("dark-theme");

      if ($("#sidebar").hasClass("close")) {
        $("#logo_sidebar")
          .fadeOut(150, function () {
            $("#logo_sidebar").attr("src", "img/app_logo.png");
            $("#logo_sidebar").attr("width", "40");
          })
          .fadeIn(100);
      } else {
        $("#logo_sidebar")
          .fadeOut(150, function () {
            $("#logo_sidebar").attr("src", "img/app_logo_extend_w.png");
            $("#logo_sidebar").attr("width", "135");
          })
          .fadeIn(150);
      }
      // set stored value to 'dark'
      localStorage.setItem("dark-mode", "dark");
    }
  });
  $("#menu").click(function (e) {
    e.preventDefault();
    $("#logo_sidebar")
      .fadeOut(150, function () {
        if ($("#sidebar").hasClass("close")) {
          if ($("body").hasClass("dark-theme")) {
            $("#logo_sidebar").attr("src", "img/app_logo.png");
            $("#logo_sidebar").attr("width", "40");
          } else {
            $("#logo_sidebar").attr("src", "img/app_logo.png");
            $("#logo_sidebar").attr("width", "40");
          }
        } else {
          if ($("body").hasClass("dark-theme")) {
            $("#logo_sidebar").attr("src", "img/app_logo_extend_w.png");
            $("#logo_sidebar").attr("width", "135");
          } else {
            $("#logo_sidebar").attr("src", "img/app_logo_extend.png");
            $("#logo_sidebar").attr("width", "135");
          }
        }
      })
      .fadeIn(150);
  });
});

/*==================== Waktu ====================*/
$(document).ready(function () {
  var interval = setInterval(function () {
    var momentNow = moment();
    $("#date-part").html(momentNow.format("dddd").substring(0, 20) + ", " + momentNow.format("DD MMMM YYYY"));
    $("#time-part").html(momentNow.format("hh:mm:ss A"));
  }, 100);
});

/*========== SHOW/HIDE PASSWORD INPUT ==========*/
function togglePassword(inputField, iconField, eyeContainer) {
  $(inputField).keyup(function () {
    var inputs = $(inputField).val();
    $(eyeContainer).fadeIn("slow");
    if (inputs == "") {
      $(eyeContainer).fadeOut("slow");
    } else {
      $(eyeContainer).fadeIn("slow");
    }
  });

  $(iconField).click(function () {
    $(this).toggleClass("uil-eye-slash uil-eye");
    var input = $(inputField);
    if (input.attr("type") == "password") {
      input.attr("type", "text");
      $(iconField).css("color", "var(--first-color)");
    } else {
      input.attr("type", "password");
      $(iconField).css("color", "var(--text-color)");
    }
  });
}

// Panggil fungsi untuk masing-masing input
togglePassword("#passInput", "#iconShowHide", "#spanEye");
togglePassword("#password-confirm", "#iconShowHide2", "#spanEye2");

/*========== GET CURRENT YEAR ==========*/
var currentYear = new Date().getFullYear();
$(document).ready(function () {
  $("#year").text(new Date().getFullYear());
});

/*========== NAVBAR ==========*/
$(window).scroll(function () {
  var stickyElement = $("#sticky-element");
  var customNavbar = $(".navbar-custom");
  var stickyPosition = stickyElement.offset().top;

  if (stickyPosition <= $(window).scrollTop()) {
    // element has been pinned
    customNavbar.addClass("sticky-pinned");
  } else {
    // element is not pinned
    customNavbar.removeClass("sticky-pinned");
  }
});
