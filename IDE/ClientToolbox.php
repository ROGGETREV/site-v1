this is teh toolboxe!
<img onclick="insertContent(1);" ondragstart="dragRBX(1);" src="/images/logo.png">
<script>
function insertContent(id) {
    try{
        window.external.Insert("http://shitblx.cf/asset/?id=" + id);
    } catch(err) {
        alert("Could not insert the requested item");
    }
}
function dragRBX(id) {
    try{
        window.external.StartDrag("http://shitblx.cf/asset/?id=" + id);
    } catch(err) {
        alert("Sorry Could not drag the requested item");
    }
}
</script>