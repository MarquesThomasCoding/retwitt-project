// On affiche le preview de l'avatar du formulaire d'inscritption dans la page d'inscription :

var showPreview = (event) => {
  // On récupère l'élément input
    var input = event.target;
    // On crée un objet FileReader qui va nous permettre de lire les données du fichier
    var reader = new FileReader();

    // On indique que l'on veut gérer un événement lorsque le chargement du fichier est terminé
    reader.onload = () => {
      // On récupère l'élément preview
      var preview = document.querySelector('#preview-avatar');
      // On crée un élément image
      var image = document.createElement('img');
      // On définit le contenu de l'attribut src de l'image
      image.src = reader.result;
      preview.innerHTML = '';
      // On ajoute l'image dans l'élément preview
      preview.appendChild(image);
    };

    // On récupère le premier fichier du tableau de fichiers
    reader.readAsDataURL(input.files[0]);
}