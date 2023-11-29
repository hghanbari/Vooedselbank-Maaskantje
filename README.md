# User stories

## Functionality
**Director:**
1. As a director, I want to be able to add, edit and remove users with the following information:
    * Name of the user
    * Email of the user
    * Phone number of the user
    * Address of the user
    * Authority of the user (director, employee or volunteer)

2. As a director, I want to be able to add, edit and remove suppliers from an overview with the following information:
    * Name of the company
    * Address of the company.
    * Name of contact
    * Email of contact
    * Phone number of contact
    * Information about the next delivery
    When a supplier is removed, I will still be able to see past deliveries.

3. As a director, I want to be able to do everything the employees and volunteers can do.


**Employee:**
1. As an employee, I want to be able to add, edit and remove products with the following information:
    * Food categorie
    * Barcode (EAN)
    * Recommended age of consumer
    * Information about allergens or other dietary restrictions
	When a product is used, I won’t be able to delete that product.

2. As an employee, I want to be able to add, edit and delete product categories.
    * When a category is used, I won’t be able to delete that category.

3. As an employee, I want to be able to add, edit and delete product specifications.
    * When a specification is used, I won’t be able to delete that specification

4. As an employee, I want to be able to set expiry dates for products.
5. As an employee, I want to be able to do everything the volunteers can do.


**Volunteer:**
1. As a volunteer, I want an overview of all the products and the amount available. This overview can be sorted using:
    * Barcode
    * Product name
    * Categorie
    * Amount

2. As a volunteer, I want to be able to change my accounts following information:
    * First name
    * Last name
    * Email
    * Password
    * Phone number
    * Address

3. As a volunteer, I want an overview of customers and their relevant information. This includes:
    * family members and their ages
    * allergies in the family
    * other dietary information
	The overview can be sorted on:
    * Family name
	The overview can be searched on:
    * Family name
    * Email
    * Phone number
	
4. As a volunteer, I want to be able to assemble a food packet for customers based on relevant information given in the previous statement. (This will also change the available amount in the stock)

## Pages
1. Log in
2. Edit profile
    * Password
    * Email
    * Name
3. Home
    * Today's tasks
    * Food packets
    * Deliveries
4. Supplier
    * Add
    * Edit
    * Delete
    * Next delivery
    * Previous delivery
5. Customers
    * Add
    * Edit
    * Delete
    * Family
        * Amount
        * Ages
6. Food packets
    * Add
    * Edit
    * Delete
    * Previous food packet
    * List per customer (Only the next one)
    * Contents
7. Stock
    * Products
        * Description
        * Amount
        * Specifics (Allergies, etc.)
        * Recommended age
        * Categorie
        * Best by date
    * Categories
        * Add
        * Edit
        * Delete
    * Specifics
        * Add
        * Edit
        * Delete
8. Manegement
    * Employees and volunteers
        * Add
        * Edit
        * Delete
        * Personal information
    * Monthly overview
        * Per product catergory
            * Poduct amount
            * Which supplier
            * Which month and year
        * Per postal code
            * Amount per product category
            * Which month and year
        * Can be printed out
