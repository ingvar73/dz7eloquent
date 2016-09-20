/**
 * Created by ingvar73 on 15.09.2016.
 */
$(function () {
   $("#image").change(function () {
      $("#load").html("<img src='/assets/template/js/img/ajax-loader.gif' alt='Loading...' style='margin-top: 20px;'>");

      $("#form").ajaxForm({
          target: 'load'
      }).submit();
   });
});