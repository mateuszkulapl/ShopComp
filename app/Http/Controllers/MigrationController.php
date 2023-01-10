<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use mysqli;

class MigrationController extends Controller
{
    //
    public function index()
    {


        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Tranfer</title>
        </head>
        <style>
        table td{
border:1px solid #ccc;
        }
        table{
            border-collapse: collapse;
        }
        </style>
        <body>';
        $servername = env('MIGRATION_SOURCE_SERVERNAME');
        $username = env('MIGRATION_SOURCE_USERNAME');
        $password = env('MIGRATION_SOURCE_PASSWORD');
        $dbname = env('MIGRATION_SOURCE_DATABASE');

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";


        $sql = "SELECT * FROM history WHERE migrated IS NULL ORDER BY id asc LIMIT 1000";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>
            <thead>
            <tr>
            <td>lp.</td>
            <td>id</td>
            <td>shop</td>
            <td>ean</td>
            <td>url</td>
            <td>price</td>
            <td>time</td>
            <td>title</td>
            <td>image</td>
            <td>promoprice</td>
            <td>oryginalprice</td>
            <td>category</td>
            <td>migrated</td>
            </tr>
            </thead>
            <tbody>
            ';
            flush();
            ob_flush();
            // output data of each row
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . ++$i . '</td>';
                foreach ($row as $column) {
                    echo '<td>' . $column . '</td>';
                }
                $price_current = null;
                if ($row['promoprice'] && $row['promoprice'] < $row['price']) {
                    $price_current = $row['promoprice'];
                } else {
                    $price_current = $row['price'];
                }
                $price_old = null;
                if ($row['oryginalprice'] && $row['oryginalprice'] > $row['price']) {

                    $price_old = $row['oryginalprice'];
                } else {
                    $price_old = $row['price'];
                }
                if ($price_old == $price_current) {
                    $price_old = null;
                }
                flush();
                ob_flush();

                $response = Http::asForm()->post('127.0.0.1:8011/api/storeMultiply/', [
                    'shop_name' => $row['shop'],
                    'ean' => $row['ean'],
                    'url' => $row['url'],
                    'title' => $row['title'],
                    'price_current' => $price_current,
                    'price_old' => $price_old,
                    'images[]' => $row['image'],
                    'creation_date' => $row['time'],
                    'categories[0][name]' => $row['category']
                ]);
                echo '</tr>';
                echo '<tr><td colspan=13>';

                echo $response->body();
                echo '</td></tr>';


                // echo '<tr><td colspan=13>';
                // if ($response->ok()) {
                //     $sql = "UPDATE history SET migrated=1 WHERE id=" . $row['id'];

                //     if ($conn->query($sql) === TRUE) {
                //         echo "Record updated successfully";
                //     } else {
                //         echo "Error updating record: " . $conn->error;
                //     }
                // } else {
                //     echo "NOT OK";
                // }
                // echo '</td></tr>';
                flush();
                ob_flush();
            }





            echo '</tbody>
          </table>';
        } else {
            echo "0 results";
        }


        $conn->close();
        exit();
    }













    public function indexMultiply()
    {
        //set max_input_vars = to 9x  rows

        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . request()->query('i') . ' Transfet multiply</title>
        </head>
        <style>
        table td{
border:1px solid #ccc;
        }
        table{
            border-collapse: collapse;
        }
        </style>
        <body>';
        $servername = env('MIGRATION_SOURCE_SERVERNAME');
        $username = env('MIGRATION_SOURCE_USERNAME');
        $password = env('MIGRATION_SOURCE_PASSWORD');
        $dbname = env('MIGRATION_SOURCE_DATABASE');

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";



        $ids = collect();
        $sql = "SELECT * FROM history WHERE migrated IS NULL AND  title!='' ORDER BY id asc LIMIT 1000";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<table>
            <thead>
            <tr>
            <td>lp.</td>
            <td>id</td>
            <td>shop</td>
            <td>ean</td>
            <td>url</td>
            <td>price</td>
            <td>time</td>
            <td>title</td>
            <td>image</td>
            <td>promoprice</td>
            <td>oryginalprice</td>
            <td>category</td>
            <td>migrated</td>
            </tr>
            </thead>
            <tbody>
            ';
            flush();
            ob_flush();
            // output data of each row
            $i = 0;
            $postData = collect();
            while ($row = $result->fetch_assoc()) {
                $ids->push($row['id']);
                echo '<tr>';
                echo '<td>' . ++$i . '</td>';
                foreach ($row as $column) {
                    echo '<td>' . $column . '</td>';
                }
                echo "</tr>";

                $price_current = null;
                if ($row['promoprice'] && $row['promoprice'] < $row['price']) {
                    $price_current = $row['promoprice'];
                } else {
                    $price_current = $row['price'];
                }
                $price_old = '';
                if ($row['oryginalprice'] && $row['oryginalprice'] > $row['price']) {

                    $price_old = $row['oryginalprice'];
                } else {
                    $price_old = $row['price'];
                }
                if ($price_old == $price_current) {
                    $price_old = '';
                }



                $postData->put('product[' . $row['id'] . '][shop_name]', $row['shop']);
                $postData->put('product[' . $row['id'] . '][ean]', $row['ean']);
                $postData->put('product[' . $row['id'] . '][url]', $row['url']);
                $postData->put('product[' . $row['id'] . '][title]', $row['title']);
                $postData->put('product[' . $row['id'] . '][price_current]', $price_current);
                $postData->put('product[' . $row['id'] . '][price_old]', $price_old);
                if ($row['image'] != NULL && $row['image'] != null)
                    $postData->put('product[' . $row['id'] . '][images][]', $row['image']);
                $postData->put('product[' . $row['id'] . '][creation_date]', $row['time']);
                $postData->put('product[' . $row['id'] . '][categories][0][name]', $row['category']);
            }
            echo '</tbody>
          </table>';
            $postData = $postData->map(function ($data) {
                return $data ? $data : '';
            });
            //dd($postData);
            flush();
            ob_flush();
            $response = Http::asForm()->post('127.0.0.1:8011/api/storemultiply/', $postData->toArray());
            echo $response->body();

            if ($response->ok()) {

                $respJson = json_decode($response->body());


                $okProducts = collect();
                foreach ($respJson as $product_id => $resp) {
                    if ($resp->status_code == 200)
                        $okProducts->push($product_id);
                }
                $sql = "UPDATE history SET migrated=1 WHERE id IN (" . $okProducts->implode(',') . ")";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "NOT OK";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        flush();
        ob_flush();

        $nextPage = intval(request()->query('i')) + 1;
        echo "<script>
        window.onload = function() {
            window.location.href = \"" . request()->url() . "?i=" . $nextPage . "\";
            }
        </script>";
        exit();
    }
}
