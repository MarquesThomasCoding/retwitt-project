// Script JS pour la page du profil


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



// Bouton de modification des informations utilisateur, permettant l'affichage du formulaire

const updateButton = () => {
    const pProfile = document.querySelector(".infos>p")
    const formProfile = document.querySelector(".form-log-sign")
    const button = document.querySelector(".modif-button")
    pProfile.classList.add("hidden")
    button.classList.add("hidden")
    formProfile.classList.remove("hidden")
}

// Style appliqué sur les options situées au bas des posts lors du survol avec la souris :

const options = document.querySelectorAll(".options")

options.forEach(option => {
    option.addEventListener("mouseover", reaction => {
        // Souris sur l'option -> l'icone apparait bleue
        option.style.color = "#71cdff"
    })
    option.addEventListener("mouseout", reaction => {
        // Souris sortie -> l'icone apparait blanche
        option.style.color = "white"
    })
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