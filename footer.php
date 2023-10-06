<script type="text/javascript ">
    const errorDiv = document.querySelector("#error");
    const pass1 = document.forms["registerForm"]["usrPassword"];
    const pass2 = document.forms["registerForm"]["usrPasswordConfirm"];
    const btnSubmit = document.forms["registerForm"]["btnRegisterUser"];

    pass2.addEventListener('input', () => {

        if (pass1.value !== pass2.value) {
            errorDiv.removeAttribute("hidden");
            btnSubmit.setAttribute("disabled", "true");
        }

        if (pass1.value === pass2.value || pass2.value === "") {
            errorDiv.setAttribute("hidden", "true");
            btnSubmit.removeAttribute("disabled");
        }

    })

    function closeMyToast(e) {
        document.querySelector(".myToast").classList.add("hide");
    }

    function openModal(resp) {
        return resp;
    }
</script>

</body>

</html>