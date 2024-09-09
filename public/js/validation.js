(function (global) {
  let nameEl = null;
  let passEl = null;
  let passAgainEl = null;
  let formEl = null;

  function init() {
    formEl = document.querySelector("form");
    passEl = document.querySelector("#password");
    passAgainEl = document.querySelector("#passwordConfirm");
    formEl.addEventListener("submit", validate);
  }

  function validate(e) {
    const passResult = validatePassword();
    const passAgainResult = validatePasswordAgain();

    if (passResult && passAgainResult) {
      // pokracuju dal data jsou OK
    } else {
      // chyba neodesilam formular
      e.preventDefault();
    }
  }

  function validatePassword() {
    if (passEl.value.length > 7) {
      passEl.parentElement.classList.remove("error");
      return true;
    } else {
      //alert('Heslo je spatne');
      passEl.parentElement.classList.add("error");
      return false;
    }
  }

  function validatePasswordAgain() {
    if (passAgainEl.value == passEl.value) {
      passAgainEl.parentElement.classList.remove("error");
      return true;
    } else {
      //alert('Heslo nejsou shodna');
      passAgainEl.parentElement.classList.add("error");
      return false;
    }
  }

  global.init = init;
})(window);
