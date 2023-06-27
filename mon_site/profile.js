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