function MakeTheCodeFlat(){
  let text = window.prompt("sometext","defaultText");
  let textLength = text.length;
  
  while(text.indexOf("\r\n\ ") != -1) {
      text = text.replace("\r\n","");
    }
  /*
  while(text.indexOf(" ") != -1){
      text = text.replace(" ", "");
  
  }
  */
  text = text.split("");
  let i2 = 1;
  for(i = 0; i < textLength; i++){
    if(text[i] == " "){
      while(text[i+i2] == " "){
        text[i + i2] = "";
        i2++;
      }
      i2 = 1;
    }
  }
  text = text.join("");
  console.log(text);
}

// Restricts input for the given textbox to the given inputFilter function.
function setInputFilter(textbox, inputFilter, errMsg) {
  [ "input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout" ].forEach(function(event) {
    textbox.addEventListener(event, function(e) {
      if (inputFilter(this.value)) {
        // Accepted value.
        if ([ "keydown", "mousedown", "focusout" ].indexOf(e.type) >= 0){
          this.classList.remove("input-error");
          this.setCustomValidity("");
        }

        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      }
      else if (this.hasOwnProperty("oldValue")) {
        // Rejected value: restore the previous one.
        this.classList.add("input-error");
        this.setCustomValidity(errMsg);
        this.reportValidity();
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
      else {
        // Rejected value: nothing to restore.
        this.value = "";
      }
    });
  });
}