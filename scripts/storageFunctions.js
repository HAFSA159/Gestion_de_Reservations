
console.log('hafsa zwinaaa l fenna')

function addToFavorites(activityId) {
    let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
console.log(activityId)
    if (!favorites.includes(activityId)) {
        favorites.push(activityId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
    }
}


function getFavorites() {
    let favorites = localStorage.getItem('favorites');
    return favorites ? JSON.parse(favorites) : [];
}



















































































// function removeFromFavorites(activityId) {
//     let favorites = getFavorites();
//     let index = favorites.indexOf(activityId);

//     if (index !== -1) {
//         favorites.splice(index, 1);
//         localStorage.setItem('favorites', JSON.stringify(favorites));
//     }
// }


// function isFavorite(activityId) {
//     let favorites = getFavorites();
//     return favorites.includes(activityId);
// }

// // Functions for managing cart items
// function addToCart(activityId) {
//     let cartItems = getCartItems();

//     if (!cartItems.includes(activityId)) {
//         cartItems.push(activityId);
//         localStorage.setItem('cartItems', JSON.stringify(cartItems));
//     }
// }

// function removeFromCart(activityId) {
//     let cartItems = getCartItems();
//     let index = cartItems.indexOf(activityId);

//     if (index !== -1) {
//         cartItems.splice(index, 1);
//         localStorage.setItem('cartItems', JSON.stringify(cartItems));
//     }
// }

// function getCartItems() {
//     let cartItems = localStorage.getItem('cartItems');
//     return cartItems ? JSON.parse(cartItems) : [];
// }

// function clearCart() {
//     localStorage.removeItem('cartItems');
// }
