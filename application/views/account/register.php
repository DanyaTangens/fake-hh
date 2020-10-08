<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Pегистрация</div>
        <div class="card-body">
            <form action="/account/register" method="post">
                <div class="form-group">
                    <label>Логин</label>
                    <input class="form-control" type="text" name="login">
                </div>
                <div class="form-group">
                    <label>Имя(только латиница)</label>
                    <input class="form-control" type="text" name="name">
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input class="form-control" type="password" name="password">
                </div>
                <div class="form-group">
                    <label>Повторите пароль</label>
                    <input class="form-control" type="password" name="password_2">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
            </form>
            <br />
            <a class="btn btn-secondary btn-block" href="/" role="button">На главную</a>
        </div>
    </div>
</div>