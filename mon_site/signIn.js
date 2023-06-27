// On affiche le preview de l'avatar du formulaire d'inscritption dans la page d'inscription :

var showPreview = (event) => {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = () => {
      var preview = document.querySelector('#preview-avatar');
      var image = document.createElement('img');
      image.src = reader.result;
      preview.innerHTML = '';
      preview.appendChild(image);
    };

    reader.readAsDataURL(input.files[0]);
}