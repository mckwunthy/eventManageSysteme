<nav class="navbar navbar-expand-lg bg-black sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Events MS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <?php
                if (isset($_SESSION["user"]["email"])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/create_event">Create Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/participate_event/<?php echo $_SESSION["user"]["id"]; ?>">Participate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Log Out</a>
                    </li>
                    <li class="nav-item username">
                        <a class="nav-link username"><?php echo "Welcome @ " . $_SESSION["user"]["fullname"]; ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <form class="d-flex signin" method="POST" action="signin" id="singinForm">
                        <input class="me-1" type="email" name="userEmail" placeholder="email">
                        <input class="me-1" type="password" name="userPassword" placeholder="password">
                        <button type="submit" name="submit">Sign In</button>
                    </form>
                    <button type="submit" name="submit" id="createAccountBt">Create Account</button>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="createAccountBox d-none">
    <form action="create_account" method="POST" id="createAccountForm">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="fullname" class="form-label">fullname</label>
            <input type="text" class="form-control" id="fullname" name="fullname" required>
        </div>
        <div class="mb-3 d-flex flex-column">
            <label for="sexe" class="form-label">sexe</label>
            <select name="sexe" id="sexe">
                <option value="masculin" selected>masculin</option>
                <option value="feminin">feminin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">age</label>
            <input type="number" class="form-control" id="age" name="age" required>
        </div>
        <div class="d-flex gap-2 col-6 mx-auto">
            <button class="btn btn-warning flex-grow-1" type="submit">Create</button>
            <button class="btn btn-danger flex-grow-3 closeBt" type="button">close</button>
        </div>
    </form>
</div>