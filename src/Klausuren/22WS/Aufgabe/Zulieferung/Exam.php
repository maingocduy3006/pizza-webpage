<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
/**
 * Class PageTemplate for the exercises of the EWA lecture
 * Demonstrates use of PHP including class and OO.
 * Implements Zend coding standards.
 * Generate documentation with Doxygen or phpdoc
 *
 * PHP Version 7.4
 *
 * @file     PageTemplate.php
 * @package  Page Templates
 * @author   Bernhard Kreling, <bernhard.kreling@h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
 * @version  3.1
 */

// to do: change name 'PageTemplate' throughout this file
require_once './Page.php';

/**
 * This is a template for top level classes, which represent
 * a complete web page and which are called directly by the user.
 * Usually there will only be a single instance of such a class.
 * The name of the template is supposed
 * to be replaced by the name of the specific HTML page e.g. baker.
 * The order of methods might correspond to the order of thinking
 * during implementation.
 * @author   Bernhard Kreling, <bernhard.kreling@h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
 */
class Exam extends Page
{
    // to do: declare reference variables for members 
    // representing substructures/blocks

    /**
     * Instantiates members (to be defined above).
     * Calls the constructor of the parent i.e. page class.
     * So, the database connection is established.
     * @throws Exception
     */
    protected function __construct()
    {
        parent::__construct();
        // to do: instantiate members representing substructures/blocks
    }

    /**
     * Cleans up whatever is needed.
     * Calls the destructor of the parent i.e. page class.
     * So, the database connection is closed.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is returned in an array e.g. as associative array.
	 * @return array An array containing the requested data. 
	 * This may be a normal array, an empty array or an associative array.
     */
    protected function getViewData():array
    {
        $sql = " SELECT * FROM interaction  ";
        $recordSet = $this->_database->query($sql);
        if(!$recordSet) {
            throw new Exception("keine Article in der Datenbank");
        }
        $data = array();
        while($record = $recordSet->fetch_assoc()){
            $id = $record["id"];
            $question = $record["question"];
            $answer = $record["answer"];
            $data[] = array(
                "id" => $id,
                "question" => $question,
                "answer" => $answer,
            );
        }
        $recordSet->free();
        return $data;
    }

    /**
     * First the required data is fetched and then the HTML is
     * assembled for output. i.e. the header is generated, the content
     * of the page ("view") is inserted and -if available- the content of
     * all views contained is generated.
     * Finally, the footer is added.
	 * @return void
     */
    protected function generateView(): void
{
    $data = $this->getViewData(); 
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HDA_ChatBot</title>
        <script src="Exam.js"></script>
    </head>
    <body>
        <h1>
            <strong>HDA_ChatBot</strong>
        </h1>
        <nav>
            <a href="Home.php">Home</a>
            <a href="Impressum.php">Impressum</a>
            <a href="Datenschutz.php">Datenschutz</a>
        </nav> 
        <h1>
            <strong>Folgendes kann man mich fragen</strong>
        </h1>
        <ul>
        <li>1. Wer bist du?</li>
        <li>2. Wie alt bist du </li>
        <li>3. Was ist dein Lieblingsessen</li>
        <li>4. Was ist dein Lieblingsfach</li>
        <li>5. Was ist deine Meinung zu Informatik</li>
    </ul>
    <h1>
            <strong>Chatausgabe</strong>
        </h1>
        <div id="chatausgabe"></div>
        <input type="text" id="eingabefeld">
        <button onclick="requestData()">Abschicken</button>

    </body>
    </html>
HTML;

    $this->generatePageHeader('Copyright Ngoc Duy Mai'); //to do: set optional parameters
    // to do: output view of this page
    $this->generatePageFooter();
}

    /**
     * Processes the data that comes via GET or POST.
     * If this page is supposed to do something with submitted
     * data do it here.
	 * @return void
     */
    protected function processReceivedData():void
    {
        parent::processReceivedData();
        // to do: call processReceivedData() for all members
    }

    /**
     * This main-function has the only purpose to create an instance
     * of the class and to get all the things going.
     * I.e. the operations of the class are called to produce
     * the output of the HTML-file.
     * The name "main" is no keyword for php. It is just used to
     * indicate that function as the central starting point.
     * To make it simpler this is a static function. That is you can simply
     * call it without first creating an instance of the class.
	 * @return void
     */
    public static function main():void
    {
        try {
            $page = new Exam();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            //header("Content-type: text/plain; charset=UTF-8");
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}


Exam::main();

