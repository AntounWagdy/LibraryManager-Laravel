<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrows;
use stdClass;

class getBooks extends Controller
{
    public static $pid = NULL;

    /**
     * Replace confusing arabic letters with regular letters.
     */
    function adjustString($str)
    {
        $removeAlef = str_replace(["أ", "إ", "آ"], "ا", $str);
        return str_replace(["ى"], "ي", $removeAlef);
    }

    /**
     * This functions gets Books by relevant books data.
     */
    function getBookByData(Request $req)
    {
        if ($req->input('qr')) {
            $barcode = $req->input('qr');
            $barcode = substr($barcode, 0, 12);
            error_log($barcode);
            $data = Book::where('CODE', $barcode);
            return view('viewer', ['data' => $data->get()]);
        } else {
            $name = $this->adjustString($req->input('search'));
            $author = $this->adjustString($req->input('author'));
            $section = $req->input('section');
            $shelf = $req->input('shelf');

            $data = Book::where('NAME', 'like', '%' . $name . '%');
            if ($author) {
                $data->where('AUTHOR', 'like', '%' . $author . '%');
            }
            if ($shelf) {
                $data->where('SHELF', $shelf);
            }
            if ($section) {
                $data->where('SECTION', $section);
            }

            return view('viewer', ['data' => $data->get()]);
        }
    }
    /**
     * This function is responsible for reading bar code.
     */
    function getBar()
    {
        ob_implicit_flush(true);
        ob_end_flush();

        $cmd = 'zbarcam.exe  -q --raw';

        $descriptorspec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );
        flush();


        $process = proc_open($cmd, $descriptorspec, $pipes, NULL, NULL);
        $status = proc_get_status($process);
        getBooks::$pid = $status['pid'];
        if (is_resource($process)) {
            stream_set_blocking($pipes[1], 1);
            if ($s = fgets($pipes[1])) {
                exec('taskkill /F /T /PID ' . $status['pid']);
                getBooks::$pid = NULL;
                return $s;
            }
        }
        return NULL;
    }


    /**
     * Borrow book given book id and user name
     */
    function borrow(Request $req)
    {
        if ($req->input("id")) {
            // edit number of copies
            $book = Book::find($req->input("id"));
            if ($book->COPIES <= 0) {
                return back()->withErrors(['borrow_error']);
            }
            $book->COPIES = $book->COPIES - 1;
            $book->save();

            // insert a borrow row
            Borrows::insert([
                'ID' => $req->input("id"),
                'CLASS' => $req->input("class"),
                'NAME' => $this->adjustString($req->input("name"))
            ]);
        }

        if ($req->input("book_id")) {
            $data = Book::join('borrows', 'Books.id', '=', 'borrows.id')
                ->where('books.ID', '=', $req->input("book_id"))
                ->select('books.name', 'books.id', 'borrows.*')->get();
        } else {
            $data = Book::join('borrows', 'Books.id', '=', 'borrows.id')
                ->select('books.name', 'books.ID', 'borrows.*')->get();
        }
        $obj = json_decode("");
        foreach ($data as $row) {
            $name = $row['CLASS'] . "/ " . $row['NAME'];

            if (!isset($obj[0][$name])) {
                $obj[0][$name] = [[$row['name'], $row['ID']]];
            } else {
                array_push($obj[0][$name], [$row['name'], $row['ID']]);
            }
        }
        if (isset($obj[0]))
            return view('borrows_view', ['data' => $obj[0]]);
        else
            return view('borrows_view', ['data' => NULL]);
    }

    /**
     * Return a book given user id and book id
     */
    function return_book(Request $req)
    {
        $book_id = $req->input("book_id");
        $user_name = $req->input("name");
        $list = explode("/ ", $user_name);
        $class_name = $list[0];
        $name = $list[1];

        // increase number of copies
        $book = Book::find($book_id);
        $book->COPIES = $book->COPIES + 1;
        $book->save();


        Borrows::where('CLASS', '=', $class_name)
            ->where('NAME', '=', $name)
            ->where('ID', '=', $book_id)->delete();

        return redirect("/borrow");
    }
}
