<!doctype html>
<html><body>
<form method="POST" action="/debug-upload" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" accept="image/*" multiple>
    <button>Send</button>
</form>
</body></html>
