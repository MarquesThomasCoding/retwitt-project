// Effets du clic sur le menu :

// Selection de tous les éléments du document
const all = document.querySelector("*")

// Sélection de l'élément "menu" et de la barre de navigation sur mobile
const menu = document.querySelector("i.menu")
const sideBarMobile = document.querySelector(".side-bar-mobile")

menu.addEventListener('click', reaction => {
    // Ajout ou suppression de la class "oppened" de la barre de navigation mobile (la faisant apparaitre ou disparaitre)
    sideBarMobile.classList.toggle("oppened")
    // Ajout ou suppression de la class "no-overflow" de tous les éléments du document (permettant ou non de scroller)
    all.classList.toggle("no-overflow")
})



// Rechargement de la page via le symbole situé sur la barre de navigation :

const reload = document.querySelector("#reload")

reload.addEventListener("click", reaction => {
    // Changement du style de l'élément, en le faisant tourner de 360 degrés
    reload.style.transform = "rotate(360deg)"
    // Intervalle de 2 secondes avant de recharger la page
    setTimeout(function(){
        window.location.reload();
     }, 2000);
})


// Vérification de la connexion de l'utilisateur à une session :

const checkSession = () => {
    // On utilise fetch pour envoyer une requête à la page check-login.php, qui renvoie un objet JSON contenant la valeur de la variable $_SESSION['loggedIn'] (true ou false)
    return fetch('check-login.php')
    // On récupère la réponse de la requête, et on la transforme en objet JSON
      .then(response => response.json())
    // On récupère la valeur de la variable $_SESSION['loggedIn'] contenue dans l'objet JSON
      .then(data => {
        // On retourne la valeur de la variable $_SESSION['loggedIn']
         return data['loggedIn'];
      })
      .catch(error => {
        // En cas d'erreur, on affiche un message dans la console et on renvoie false
         console.error('Erreur lors de la vérification de la connexion à la session :', error);
         return false;
      });
}


// Si l'utilisateur n'est pas connecté, on crée un élément div enfant du body avec la class blocked et on affiche un message dedans après qu'il est scrollé, et à condition qu'il ne l'ai pas déjà fait :

checkSession()
// On récupère la valeur de la variable $_SESSION['loggedIn'] retournée par la fonction checkSession()
.then(isLoggedIn => {
    // Si la valeur de la variable $_SESSION['loggedIn'] est false, on affiche un message dans la console et on crée l'élément div.blocked
    if(!isLoggedIn) {
        console.log("Vous n'êtes pas connecté")
        const body = document.querySelector("body")
        const existBlocked = document.querySelector(".blocked")

        // On crée un booléen blockedCreated qui permettra de savoir si l'élément div.blocked a déjà été créé
        var blockedCreated = false

        // On ajoute un écouteur d'évènement sur le scroll de la fenêtre
        window.addEventListener("scroll", reaction => {
            // Si l'utilisateur scroll, on vérifie si l'élément div.blocked a déjà été créé, et si ce n'est pas le cas, on le crée
            if(!blockedCreated) {
                if(!existBlocked) {
                    const blocked = document.createElement("div")
                    blocked.classList.add("blocked")
                    body.appendChild(blocked)
                    const message = document.createElement("h2")
                    message.innerHTML = "<a href='login.php'>Log in</a> to see all the posts"
                    blocked.appendChild(message)
                }
                // On passe le booléen blockedCreated à true pour ne pas recréer l'élément div.blocked
                blockedCreated = true
            }
        })
    }
    else {
        console.log("Vous êtes connecté")
    }
})

// Pop-up de confirmation de suppression du post

const DeletePostModal = document.querySelector(".confirm-delete")
const DeletePostModalContent = document.querySelector(".confirm-delete-content")
const DeletePostModalButton = document.querySelector("button.confirm-delete-content-buttons")
const DeletePostModalButtonClose = document.querySelector("button.confirm-delete-content-buttons-close")

// Pop-up qui confirme l'action sur le post, qui disparait au bout de 5 secondes avec une barre de progression :

const ActionPostModal = document.querySelector(".confirm-action")
const ActionPostModalContent = document.querySelector(".action-post-modal-content")
const ActionPostModalBar = document.querySelector(".action-post-modal-bar")
const ActionPostModalBarProgress = document.querySelector(".action-post-modal-bar-progress")

const deleteBtn = document.querySelectorAll("button.del-icon")
const savedBtn = document.querySelectorAll("button.saved-icon")

deleteBtn.forEach(post => {
    post.addEventListener("click", reaction => {
        reaction.preventDefault()
        // On fait apparaitre le pop-up de confirmation de suppression du post
        DeletePostModal.style.display = "flex"
        DeletePostModalButtonClose.addEventListener("click", reaction => {
            reaction.preventDefault()
            // On fait disparaitre le pop-up de confirmation de suppression du post
            DeletePostModal.style.display = "none"
        })
        DeletePostModalButton.addEventListener("click", reaction => {
            reaction.preventDefault()
            // On fait apparaitre le pop-up qui confirme la suppression du post
            DeletePostModal.style.display = "none"
            // On cache le post (ce qui donne l'illusion temporaire qu'il a été supprimé)
            post.parentElement.parentElement.parentElement.style.display = "none"
            ActionPostModalContent.innerHTML = "Post deleted"
            ActionPostModal.style.display = "flex"
            // On fait disparaitre le pop-up au bout de 5 secondes
            setTimeout(function(){
                ActionPostModal.style.display = "none"
                // On soumet le formulaire de suppression du post
                post.parentElement.submit()
                }, 5000);
            // On lance la barre de progression
            let i = 0
            let interval = setInterval(function() {
                // On incrémente la variable i de 1
                i++
                // On définit la largeur de la barre de progression en fonction de la variable i
                ActionPostModalBarProgress.style.width = 100 - i + "%"
                // Si la variable i atteint 100, on arrête la barre de progression
                if(i === 100) {
                    clearInterval(interval)
                }
            }, 50)
        })
    })
})


// Pop-up de confirmation de sauvegarde du post, qui disparait au bout de 5 secondes avec une barre de progression :

savedBtn.forEach(post => {
    post.addEventListener("click", reaction => {
        reaction.preventDefault()
        // Si on est sur la page saved.php, on fait disparaitre le post
        if(window.location.href.indexOf("saved.php") > -1) {
            post.parentElement.parentElement.parentElement.style.display = "none"
        }
        // On fait apparaitre le pop-up de confirmation de sauvegarde du post
        ActionPostModalContent.innerHTML = "Post saved"
        ActionPostModal.style.display = "flex"
        // On fait disparaitre le pop-up au bout de 5 secondes
        setTimeout(function(){
            ActionPostModal.style.display = "none"
            // On soumet le formulaire de sauvegarde du post
            post.parentElement.submit()
            }, 5000);
        // On lance la barre de progression
        let i = 0
        let interval = setInterval(function() {
            // On incrémente la variable i de 1 toutes les 50 millisecondes
            i++
            // On définit la largeur de la barre de progression en fonction de la variable i
            ActionPostModalBarProgress.style.width = 100 - i + "%"
            // Si la variable i atteint 100, on arrête la barre de progression
            if(i === 100) {
                clearInterval(interval)
            }
        }, 50)
    })
})

// Sélection des tags pour filtrer les posts :

const filters = document.querySelector(".filters")
const tagsFilters = document.querySelector(".tags-filter")
const tagsMenu = document.querySelector(".tags-menu")
const tagsContent = document.querySelector(".tags-content")
const tagI = tagsFilters.querySelector("i")

tagsMenu.addEventListener("click", reaction => {
    // Si les tags ne sont pas visibles, on les fait apparaitre
    if(getComputedStyle(tagsContent).display === "none") {
        filters.style.marginBottom = "5.5vh"
        tagI.style.transform = "rotate(180deg)"
        tagsContent.style.display = "flex"
    }
    // Sinon on les cache
    else {
        filters.style.marginBottom = "0"
        tagI.style.transform = "rotate(0deg)"
        tagsContent.style.display = "none"
    }
})

const tagChoice = document.querySelectorAll(".tag-choice")

// Tableau des tags avec leur couleur associée
const tags = {
    "voyage" : "rgb(16, 134, 164)",
    "jeu-video" : "rgb(16, 101, 164)",
    "innovation" : "rgb(16, 56, 164)",
    "musique" : "rgb(87, 16, 164)",
    "television" : "rgb(164, 16, 162)",
    "animaux" : "rgb(164, 16, 56)",
    "peinture" : "rgb(164, 58, 16)",
    "lecture" : "rgb(164, 125, 16)",
    "sport" : "rgb(132, 164, 16)",
    "loisirs" : "rgb(60, 164, 16)"
}

const post = document.querySelectorAll(".post")
const root = document.querySelector(":root")

// Pour chaque post, on ajoute un écouteur de clic
tagChoice.forEach(tag => {
    tag.addEventListener("click", reaction => {
        //Lors du clic sur un tag, on le définit en "actif" et on enlève cette class aux autres tags
        tag.classList.add("tag-active")
        tagChoice.forEach(t => {
            if(t != tag) {
                t.classList.remove("tag-active")
            }
        })

        // On parcourt le tableau des tags pour afficher les posts correspondants au tag cliqué et changer la couleur du tag-preview et des icones lors de leur survol

        for(const tagged in tags) {
            // Si le tag cliqué est "all", on affiche tous les posts
            if(tag.classList.contains("all")) {
                // On affiche tous les posts
                post.forEach(p => { p.classList.remove("hidden") })
                // On met la couleur du tag-preview à sa valeur par défaut
                root.style.setProperty('--tag-preview-color', 'rgb(199, 197, 197)');
            }
            // Sinon, on affiche les posts correspondants au tag cliqué
            else if(tagged == tag.classList[1]) {
                // On met la couleur du tag-preview à la couleur du tag cliqué
                root.style.setProperty('--tag-preview-color', tags[tagged]);
                // On affiche les posts correspondants au tag cliqué
                post.forEach(p => {
                    if(!p.classList.contains(tagged)) {
                        p.classList.add("hidden")
                    }
                    else {
                        p.classList.remove("hidden")
                    }
                })
            }
        }
    })
})



// Création d'un nouveau post :

const newPost = document.querySelector("#new-post-modal")

// Style appliqué au bouton pour faire un nouveau post
newPost.addEventListener('mouseover', reaction => {
    newPost.classList.remove("fa-regular")
    newPost.classList.add("fa-solid")
})

newPost.addEventListener('mouseout', reaction => {
    newPost.classList.remove("fa-solid")
    newPost.classList.add("fa-regular")
})


const newPostContent = document.querySelector(".new-post-modal-content")
const posts = document.querySelector(".posts")
const profile = document.querySelector(".profile-card")
const twittContent = newPostContent.querySelector("#twitt-content")
const twittTag = newPostContent.querySelector("#twitt-tag")

// On vérifie si l'utilisateur avait déjà commencé à écrire quelque chose
// Si oui, on affiche ce qu'il avait écrit
// Si non, on affiche un textarea vide
if(localStorage.getItem('twitt-content') == null) {
    twittContent.value = ""
}
else {
    twittContent.value = localStorage.getItem('twitt-content')
}

if(localStorage.getItem('twitt-tag') == null) {
    twittTag.value = tags[0]
}
else {
    twittTag.value = localStorage.getItem('twitt-tag')
}

// On floute les éléments situés sous le pop-up du nouveau post, on empêche le scroll et on affiche le pop-up
newPost.addEventListener('click', reaction => {
    posts.classList.toggle("blur")
    if(profile) {
        profile.classList.toggle("blur")
    }
    all.classList.toggle("no-overflow")
    // On affiche le pop-up s'il est caché, et on le cache s'il est affiché
    if(getComputedStyle(newPostContent).display === "flex") {
        newPostContent.style.display = "none"
    }
    else {
        newPostContent.style.display = "flex"
    }
    // Sauvegarde du texte écrit par l'utilisateur lors de la fermeture du pop-up sans publication du post
    localStorage.setItem('twitt-content', twittContent.value)
    localStorage.setItem('twitt-tag', twittTag.value)
})

// On affiche un aperçu du média sélectionné par l'utilisateur pour le nouveau post

var showPreview = (event) => {
    // On récupère l'élément input
    var input = event.target;
    // On crée un objet FileReader qui va nous permettre de lire les données du fichier
    var reader = new FileReader();

    // On indique que l'on veut gérer un événement lorsque le chargement du fichier est terminé
    reader.onload = () => {
    // On récupère l'élément preview
      var preview = document.getElementById('preview');
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
