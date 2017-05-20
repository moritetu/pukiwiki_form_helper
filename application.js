(function() {
  $(function() {
    var $textarea = $(".edit_form form textarea[name='msg']");
    $(".quick-toolbar button").click(function() {
      var pos   = get_cursor_position($textarea.get(0)),
          value = $textarea.val()
      ;

      var text = value.substring(pos.start, pos.end);
      var data_text = replace_text_n($(this).attr("data-text"), text);

      if (data_text.indexOf("@func") == 0) {
        var func_name = data_text.substring("@func:".length);
        data_text = eval(func_name);
        if (!data_text) {
          return;
        }
      }
      insert_text(data_text, pos);
    });
    
    function insert_text(data_text, pos) {
      data_text = data_text.replace(/^ +/, "").replace(/ +$/, "");
      var _value = "";
      _value += $textarea.val().substring(0, pos.start);
      _value += data_text;
      _value += $textarea.val().substring(pos.end);
      $textarea.val(_value);
    }

    function get_cursor_position(text_elm) {
      return {start: text_elm.selectionStart, end: text_elm.selectionEnd};
    }

    function insert_contents(text) {
      var value = $textarea.val();
      if (value.indexOf("#contents") < 0) {
        insert_text("#contents\n\n", get_cursor_position($textarea));
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

    function line_break_in_cell(text) {
      return text.split("。").join("。&br;");
    }

    function replace_text_n(data_text, text) {
      var i = 1, new_text = data_text;
      var text_list = text.split(":::");
      if (data_text.indexOf("@text1@") < 0) {
        return data_text.replace(/@text@/g, text);
      }
      while (new_text.indexOf("@text" + i + "@") >= 0 && text_list.length >= i) {
        new_text = new_text.replace("@text" + i + "@", text_list[i - 1], "g");
        i++;
      }
      return new_text;
    } 
  });
})();
