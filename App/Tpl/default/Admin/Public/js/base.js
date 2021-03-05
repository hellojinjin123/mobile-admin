$(function () {
  $("body").append(
    '<div class="bottom-copyright bottom-fixed">版权所有.<a href="#" target="_blank">志翼 科技</a>. 技术支持.<a href="#" target="_blank">jmh-技术部</a>&nbsp;&nbsp;&nbsp;</div>'
  );
});

//URL跳转
function goToUrl(url) {
  window.location.href = url;
}

function set_publish() {
  if ($("#publish").attr("checked") == "checked") {
    $("#is_publish").val("1");
  } else {
    $("#is_publish").val("0");
  }
}
