<?php

use PHPUnit\Framework\TestCase;

class add_bookTest extends TestCase
{
    public function testAddBook()
    {
        $connection = mysqli_connect("localhost", "root" ,"", "library_app");

        // Prepare test data
        $title = "Test Book";
        $coverName = "test_cover";
        $ImageData = "test_cover.png";

        // Insert test data into database
        $InsertSQL = "insert into books (title) values ('$title')";
        mysqli_query($connection, $InsertSQL);

        // Call add_book.php with test data
        $_POST['title'] = $title;
        $_POST['coverName'] = $coverName;
        $_POST['ImageData'] = $ImageData;
        ob_start();
        include 'add_book.php';
        $output = ob_get_clean();

        // Check if book cover was uploaded successfully
        $this->assertStringContainsString("Your Image Has Been Uploaded.", $output);

        // Check if book cover URL was saved in database
        $SelectSQL = "select cover from books where title = '$title'";
        $connection = mysqli_connect("localhost", "root" ,"", "library_app");
        $result = mysqli_query($connection, $SelectSQL);
        $row = mysqli_fetch_assoc($result);
        

        // Clean up test data from database
        $DeleteSQL = "delete from books where title = '$title'";
        mysqli_query($connection, $DeleteSQL);

        mysqli_close($connection);
    }
}