# Ecommerce app
Ecommerce built using laravel 9, vue 3, inertia.js and stripe to make payments.
I developed the project using a TDD approach.<br>

### DB structure
![Db-structure](public/demo/DB_structure.png)

### Shop
The user can view the products for sale.
He can search for a product by name, or filter them by category or price.
He can also sort them by price or best sellers.

filter-demo

Once logged in, the user can add products to his shopping cart, to his wishlist or save products to purchase them later.<br>
When the user clicks the checkout button he is redirected to the payment page provided by stripe.

purchase-demo


### User Dashboard
From the dashboard a registered user can summarize his purchases, view how many orders he has placed in a period of time, how much he has spent on average, etc.
He can also view his orders in detail and update his profile information (username and password).

dashboard-demo