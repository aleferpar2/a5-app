<form method="POST" action="/login">
    @csrf
    <input type="email" name="email" placeholder="email"/>
    <input type="password" name="password" placeholder="password"/>
    <input type="submit" value="login"/>
</form>
