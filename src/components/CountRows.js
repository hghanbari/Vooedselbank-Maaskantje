const mysql = require('mysql2');

// Create a MySQL connection
const connection = mysql.createConnection({
  host: 'roc-dev.faisonic.com/phpmyadmin',
  user: 'c50496maaskantje',
  password: 'hqi4G!rTQiZU',
  database: 'your_database_name'
});

// Connect to the database
connection.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL:', err);
    return;
  }
  console.log('Connected to MySQL database');
});

// Query to count rows in a specific table
const tableName = 'your_table_name';
const countQuery = `SELECT COUNT(*) AS rowCount FROM ${tableName}`;

// Execute the count query
connection.query(countQuery, (err, results) => {
  if (err) {
    console.error('Error executing count query:', err);
    return;
  }

  // Extract the row count from the results
  const rowCount = results[0].rowCount;

  console.log(`Number of rows in ${tableName}: ${rowCount}`);

  // Close the database connection
  connection.end((err) => {
    if (err) {
      console.error('Error closing MySQL connection:', err);
    } else {
      console.log('MySQL connection closed');
    }
  });
});
