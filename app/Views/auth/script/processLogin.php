<script>
  const formLogin = document.getElementById("login-form");
  const loginButton = document.getElementById("login-button");

  formLogin.addEventListener("submit", async (e) => {
    e.preventDefault();
    loginButton.disabled = true;
    loginButton.innerText = "Memproses...";

    // get form data
    const formData = new FormData(formLogin);
    const data = Object.fromEntries(formData);

    const response = await fetch("/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(data)
    });

    const result = await response.json();

    if (result.status === "success") {
      loginButton.disabled = false;
      loginButton.innerText = "Login";
      // clear form
      formLogin.reset();

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
      }).showToast();

      window.location.href = "/dashboard";

    } else {
      loginButton.disabled = false;
      loginButton.innerText = "Login";

      Toastify({
        text: result.message,
        duration: 3000,
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
      }).showToast();
    }
  })
</script>