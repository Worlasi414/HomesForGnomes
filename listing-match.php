<?php
/*
Name:         	Ramandeep Rathor
Name:           Musab Nazir
Name:			Kevin Astilla
Name:			Nathan Morris
Description:  	Listing-match file For Homes For Gnomes
Date:         	10th December 2018
*/

require "header.php";

if(isset($_SESSION['listingList']))
{
    $listings = $_SESSION['listingList'];
}
else {
    $_SESSION['RedirectError'] = "No search was made<br/>";
    header("Location:listing-search.php");
    ob_flush();
}
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
    $listingCount = ($page -1) * IMAGE_LIMIT;
}
else {
    $page=1;
    $listingCount = 0;
 }

$conn = db_connect();
echo '<div class="container"><div class="row" style="margin-top:75px">';
for ($listingCount; $listingCount < count($listings); $listingCount++) {
    $sql = "SELECT * FROM listings WHERE listing_id = $listings[$listingCount]";
    $result = pg_query($conn, $sql);
    for($index = 0; $index < pg_num_rows($result); $index++)
    {
        echo '<div class="col-md-4"style="margin-top:1em"><div class="card"><div class="card-body">';
         $arrayRow = pg_fetch_array($result,$index);
        echo (build_listing_card($arrayRow));
        echo '</div></div></div>';
    }
    if($listingCount !=0 && ($listingCount +1) % IMAGE_LIMIT ==0){
        break;
    }
}

?>
  <!-- start of main page content -->

    </div>
    </div>
    <br/>
    <div class="row justify-content-md-center">
    <?php
    $total_pages = ceil(count($listings) / IMAGE_LIMIT);
    $pagLink = "<div class='pagination'>";
    for ($i=1; $i<=$total_pages; $i++) {
                 if($i == $page)
                 {
                    $pagLink .= "<a class='active' href='listing-match.php?page=".$i."'>".$i."</a>";
                 }
                 else {
                     $pagLink .= "<a href='listing-match.php?page=".$i."'>".$i."</a>";
                 }
    };
    echo $pagLink . "</div>";
     ?>
 </div>
 <br/>

  <!-- end of main page content -->

<!-- Footer Start -->
<?php
  include 'footer.php'
?>
<!-- Footer End -->
