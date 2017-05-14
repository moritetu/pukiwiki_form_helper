(function() {
  $(function() {
    var $textarea = $(".edit_form form textarea[name='msg']");
    $(".quick-toolbar button").click(function() {
      var pos_s = $textarea.get(0).selectionStart,
          pos_e = $textarea.get(0).selectionEnd,
          value = $textarea.val();
      ;

      var text = $textarea.val().substring(pos_s, pos_e);
      // raw_text.split("\n").forEach(function(val, index) {
      //        var line = val.trim();
      //        if (line.length == 0) return;
      //        text.push(line);
      // });
      // text = text.join("\n");
      var data_text = $(this).attr("data-text").replace(/@text@/g, text);

      if (data_text.indexOf("@func") == 0) {
        var func_name = data_text.substring("@func:".length);
        data_text = eval(func_name);
        if (!data_text) {
          return;
        }
      }

      data_text = data_text.replace(/^ +/, "").replace(/ +$/, "");
      if (pos_e > 0 && text) {
        var _value = "", len = text.length;
        _value += value.substring(0, pos_s);
        _value += data_text;
        _value += value.substring(pos_e);
        $textarea.val(_value);
      } else {
        $textarea.val(value + data_text);
      }
    });

    function insert_contents(text) {
      var value = $textarea.val();
      if (value.indexOf("#contents") < 0) {
        $textarea.val("#contents\n\n" + value);
      }
      return null;
    }

    function create_list(text, sign) {
      var lines = text.split("\n"), value = "";
      lines.forEach(function(val, index) {
        value += sign + " " + val + "\n";
      });
      return value;
    }

    function create_link_list(text, sign) {
      var lines = text.split("\n"), value = "";
      lines.forEach(function(val, index) {
        value += sign + " [[" + val + "]]\n";
      });
      return value;
    }
  });
})();