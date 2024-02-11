// var shop = {};

// function buy(button) {
//     if (button) {
//         var cardBody = button.closest('.card-body');

//         if (cardBody) {
//             var titleElement = cardBody.querySelector('.card-title');
//             var priceElement = cardBody.querySelector('.card-text');
//             var topImgElement = cardBody.closest('.card').querySelector('.card-img-top');

//             if (titleElement && priceElement && topImgElement) {
//                 var title = titleElement.textContent;
//                 var price = priceElement.textContent;
//                 var imgPath = topImgElement.src;

//                 // Add the item to the shop object
//                 shop[title] = { price: price, imgPath: imgPath };

//                 // Save the updated shop object to localStorage
//                 saveShopToLocalStorage();

//                 console.log(shop);
//             } else {
//                 console.log('Title, price, or top img element not found.');
//             }
//         } else {
//             console.log('Parent container not found.');
//         }
//     } else {
//         console.log('Button element not provided.');
//     }
// }

// document.addEventListener('DOMContentLoaded', function () {
//     // Fetch the shop object from localStorage
//     loadShopFromLocalStorage();

//     var cardContainer = document.getElementById('cardContainer');

//     // Iterate over the keys and values of the shop object
//     for (var title in shop) {
//         if (shop.hasOwnProperty(title)) {
//             var item = shop[title];
//             var card = createCardElement(title, item.price, item.imgPath);
//             cardContainer.appendChild(card);
//         }
//     }

//     function createCardElement(title, price, imgPath) {
//         var card = document.createElement('div');
//         card.className = 'card';
//         card.style.width = '12rem';

//         var img = document.createElement('img');
//         img.src = imgPath;
//         img.className = 'card-img-top';
//         img.alt = 'Cover Image';
//         img.style.height = '150px';

//         var cardBody = document.createElement('div');
//         cardBody.className = 'card-body';

//         var titleElement = document.createElement('h5');
//         titleElement.className = 'card-title';
//         titleElement.textContent = title;

//         var priceElement = document.createElement('p');
//         priceElement.className = 'card-text';
//         priceElement.textContent = price;

//         cardBody.appendChild(titleElement);
//         cardBody.appendChild(priceElement);
//         card.appendChild(img);
//         card.appendChild(cardBody);

//         return card;
//     }
// });

// function saveShopToLocalStorage() {
//     // Convert the shop object to a JSON string and save it to localStorage
//     localStorage.setItem('shop', JSON.stringify(shop));
// }

// function loadShopFromLocalStorage() {
//     // Retrieve the shop object from localStorage and parse the JSON string
//     var savedShop = localStorage.getItem('shop');
//     shop = savedShop ? JSON.parse(savedShop) : {};
// }
