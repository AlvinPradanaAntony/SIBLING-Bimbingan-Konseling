$("#data").hover(function () {
  if ($("#ico__data").attr("src") === "https://cdn.lordicon.com/sbiheqdr.json") {
    $("#ico__data").attr("src", "https://cdn.lordicon.com/nnbhwnej.json");
    $("#ico__data").attr("colors", "primary:#FFFFFF");
  } else {
    $("#ico__data").attr("src", "https://cdn.lordicon.com/sbiheqdr.json");
    $("#ico__data").attr("colors", "primary:#5372e7,secondary:#08a88a");
  }
});
$("#proses").hover(function () {
  if ($("#ico__proses").attr("src") === "https://cdn.lordicon.com/wrprwmwt.json") {
    $("#ico__proses").attr("src", "https://cdn.lordicon.com/wjrtlwtp.json");
    $("#ico__proses").attr("colors", "primary:#b4b4b4,secondary:#e4e4e4,tertiary:#1f2050,quaternary:#5372e7");
  } else {
    $("#ico__proses").attr("src", "https://cdn.lordicon.com/wrprwmwt.json");
    $("#ico__proses").attr("colors", "primary:#5372e7,secondary:#1f2050");
  }
});
