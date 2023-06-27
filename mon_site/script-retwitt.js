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
    return fetch('check-login.php')
      .then(response => response.json())
      .then(data => {
         return data['loggedIn'];
      })
      .catch(error => {
         console.error('Erreur lors de la vérification de la connexion à la session :', error);
         return false;
      });
}

console.log(checkSession())


// Si l'utilisateur n'est pas connecté, on crée un élément div enfant du body avec la class blocked et on affiche un message dedans après qu'il est scrollé, et à condition qu'il ne l'ai pas déjà fait :

checkSession()
.then(isLoggedIn => {
    if(!isLoggedIn) {
        console.log("Vous n'êtes pas connecté")
        const body = document.querySelector("body")
        const existBlocked = document.querySelector(".blocked")

        var blockedCreated = false

        window.addEventListener("scroll", reaction => {
            if(!blockedCreated) {
                if(!existBlocked) {
                    const blocked = document.createElement("div")
                    blocked.classList.add("blocked")
                    body.appendChild(blocked)
                    const message = document.createElement("h2")
                    message.innerHTML = "<a href='login.php'>Log in</a> to see all the posts"
                    blocked.appendChild(message)
                    console.log(existBlocked)
                }
                blockedCreated = true
            }
        })
    }
    else {
        console.log("Vous êtes connecté")
    }
})


// Style appliqué sur les options situées au bas des posts lors du survol avec la souris :

const options = document.querySelectorAll(".options")

options.forEach(option => {
    option.addEventListener("mouseover", reaction => {
        // Souris sur l'option -> l'icone apparait "rempli"
        option.style.color = "#71cdff"
    })
    option.addEventListener("mouseout", reaction => {
        // Souris sortie -> l'icone apparait "vide"
        option.style.color = "white"
    })
})


// Apparition du pop-up de confirmation de suppression du post, qui disparait au bout de 5 secondes avec une barre de progression :

const ActionPostModal = document.querySelector(".confirm-action")
const ActionPostModalContent = document.querySelector(".action-post-modal-content")
const ActionPostModalBar = document.querySelector(".action-post-modal-bar")
const ActionPostModalBarProgress = document.querySelector(".action-post-modal-bar-progress")

const deleteBtn = document.querySelectorAll("button.del-icon")
const savedBtn = document.querySelectorAll("button.saved-icon")

deleteBtn.forEach(post => {
    post.addEventListener("click", reaction => {
        reaction.preventDefault()
        post.parentElement.parentElement.parentElement.style.display = "none"
        // On fait apparaitre le pop-up de confirmation de suppression du post
        ActionPostModalContent.innerHTML = "Post deleted"
        ActionPostModal.style.display = "flex"
        // On fait disparaitre le pop-up au bout de 5 secondes
        setTimeout(function(){
            ActionPostModal.style.display = "none"
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


// Apparition du pop-up de confirmation de sauvegarde du post, qui disparait au bout de 5 secondes avec une barre de progression :

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
const tags = [
    "voyage",
    "jeu-video",
    "innovation",
    "musique",
    "television",
    "animaux",
    "peinture",
    "lecture",
    "sport",
    "loisirs"
]

const post = document.querySelectorAll(".post")

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

        // On affiche uniquement les posts possedant le tag sélectionné
        tags.forEach(tagged => {
            if(tag.classList.contains("all")) {
                post.forEach(p => { p.classList.remove("hidden") })
            }
            else if(tagged == tag.classList[1]) {
                post.forEach(p => {
                    if(!p.classList.contains(tagged)) {
                        p.classList.add("hidden")
                    }
                    else {
                        p.classList.remove("hidden")
                    }
                })
            }
        })
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

// On vérifie si l'utilisateur avait déjà commencé à écrire quelque chose
if(localStorage.getItem('twitt-content') == null) {
    twittContent.value = ""
}
else {
    twittContent.value = localStorage.getItem('twitt-content')
}

// On floute les éléments situés sous le pop-up du nouveau post, on empêche le scroll et on affiche le pop-up
newPost.addEventListener('click', reaction => {
    posts.classList.toggle("blur")
    if(profile) {
        profile.classList.toggle("blur")
    }
    all.classList.toggle("no-overflow")
    if(getComputedStyle(newPostContent).display === "flex") {
        newPostContent.style.display = "none"
    }
    else {
        newPostContent.style.display = "flex"
    }
    // Sauvegarde du texte écrit par l'utilisateur lors de la fermeture du pop-up sans publication du post
    localStorage.setItem('twitt-content', twittContent.value)
})

// On affiche le média sélectionné par l'utilisateur pour le nouveau post

var showPreview = (event) => {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = () => {
      var preview = document.getElementById('preview');
      var image = document.createElement('img');
      image.src = reader.result;
      preview.innerHTML = '';
      preview.appendChild(image);
    };

    reader.readAsDataURL(input.files[0]);
  }
