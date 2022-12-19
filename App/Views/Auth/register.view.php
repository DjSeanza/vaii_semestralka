<main class="register-main">
    <div class="register-bg"></div>
    <div class="register-bg-color"></div>
    <div class="register-form-div">
        <h1>Registrácia</h1>
        <form action="?c=auth&a=register" method="post" class="register-form">
            <div class="form-input-image-div">
                <label for="username" class="input-image-div">
                    <img src="public/images/Icons/user-image.png" alt="">
                </label>
                <input type="text" id="username" name="login" maxlength="64" placeholder="Používateľské meno" required>
            </div>
            <div class="form-input-image-div">
                <label for="password" class="input-image-div">
                    <img src="public/images/Icons/password-lock.svg" alt="">
                </label>
                <input type="password" id="password" maxlength="64" name="password" placeholder="Heslo" required>
            </div>
            <div class="form-input-image-div">
                <label for="email" class="input-image-div">
                    <img src="public/images/Icons/password-lock.svg" alt="">
                </label>
                <input type="email" id="email" maxlength="100" name="email" placeholder="Email" required>
            </div>
            <div class="form-input-image-div">
                <label for="profile-pic" class="input-image-div">
                    <img src="public/images/Icons/password-lock.svg" alt="">
                </label>
                <label for="profile-pic" id="file-label">
                    <span id="file-name">Vyberte profilový obrázok...</span>
                    <input type="file" id="profile-pic" accept="image/jpeg, image/jpg, image/png, image/svg" name="profile-picture" required hidden>
                </label>
            </div>
            <button type="submit" class="button" name="submit">
                Zaregistrovať
            </button>
        </form>
        <div class="register-login-question">
            <span>Už máte účet? <a href="?c=auth&a=login">Prihláste sa</a></span>
        </div>
    </div>
</main>

<script>
    let input = document.querySelector("label#file-label input#profile-pic");
    let imageName = document.querySelector("label#file-label span#file-name");

    input.addEventListener("change", ()=>{
        imageName.innerText = input.files[0].name;
        document.querySelector("label#file-label").setAttribute("title", input.files[0].name);
    })
</script>
