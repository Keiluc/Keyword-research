<h1>Form</h1>
<form action="{{ action('HomeController@recibir') }}" method="POST">
    {{ csrf_field() }}
    <label for="name">Name</label>
    <input type="text" name="name">

    <label for="email">Email</label>
    <input type="email" name="email">

    <input type="submit" value="Send">

</form>
