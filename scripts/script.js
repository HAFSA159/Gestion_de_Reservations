// pour recuperer data du local storage
function getLocalStorageData(key) {
    return JSON.parse(localStorage.getItem(key)) || [];
}

// mise a jour
function setLocalStorageData(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
}

function ajouterFavori(activite) {
    let favoris = getLocalStorageData('favoris');
    favoris.push(activite);
    setLocalStorageData('favoris', favoris);
    afficherFavoris();
}

function supprimerFavori(activiteId) {
    let favoris = getLocalStorageData('favoris');
    favoris = favoris.filter(activite => activite.id !== activiteId);
    setLocalStorageData('favoris', favoris);
    afficherFavoris();
}

function afficherFavoris() {
    let favoris = getLocalStorageData('favoris');
    let listeFavoris = document.getElementById('liste-favoris');
    listeFavoris.innerHTML = '';
    favoris.forEach(activite => {
        let li = document.createElement('li');
        li.textContent = activite.nom;
        let btn = document.createElement('button');
        btn.textContent = 'Supprimer';
        btn.onclick = () => supprimerFavori(activite.id);
        li.appendChild(btn);
        listeFavoris.appendChild(li);
    });
}

// Gestion du panier
function ajouterPanier(activite) {
    let panier = getLocalStorageData('panier');
    panier.push(activite);
    setLocalStorageData('panier', panier);
    afficherPanier();
}

function supprimerPanier(activiteId) {
    let panier = getLocalStorageData('panier');
    panier = panier.filter(activite => activite.id !== activiteId);
    setLocalStorageData('panier', panier);
    afficherPanier();
}

function afficherPanier() {
    let panier = getLocalStorageData('panier');
    let listePanier = document.getElementById('liste-panier');
    listePanier.innerHTML = '';
    panier.forEach(activite => {
        let li = document.createElement('li');
        li.textContent = activite.nom;
        let btn = document.createElement('button');
        btn.textContent = 'Supprimer';
        btn.onclick = () => supprimerPanier(activite.id);
        li.appendChild(btn);
        listePanier.appendChild(li);
    });
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    afficherFavoris();
    afficherPanier();
});
