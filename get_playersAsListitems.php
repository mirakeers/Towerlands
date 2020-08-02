<?php
    require_once './dao/PlayerDAO.php';
    
    if(isFormulierIngediend()) {
        $kleurIds = json_decode($_GET['kleurIds'], false);
        $productCategorieIds = json_decode($_GET['productCategorieIds'], false);
        $products = ProductDAO::getProductenByProperties($productCategorieIds, $_GET['minPrijsInclBtw'], $_GET['maxPrijsInclBtw'], $kleurIds);
    } else {
        $products = ProductDAO::getProducten(); 
    }
    foreach ($products as $pIndex => $product) {
        ?>
        <li id="productid<?php echo $product->getProductId()?>">
            <div class="imagebox">
                <div class="imgcontainer">
                    <?php
                        $productvariaties = ProductVariatieDAO::getProductVariatiesByProductId($product->getProductId());
                        $hitfound = false;
                        if(isFormulierIngediend()) {
                            foreach ($productvariaties as $pvIndex => $productvariatie) {
                                if(in_array($productvariatie->getKleurId(), $kleurIds)) {
                                    $startPvId = $productvariatie->getProductVariatieId();
                                    $hitfound = true;
                                    break;
                                }
                            }
                        }
                        foreach ($productvariaties as $pvIndex => $productvariatie) {
                            $fotoPriorityOne = FotoDAO::getFotoByProductVariatieIdAndPrioriteit($productvariatie->getProductVariatieId(), 1);
                            $fotoPriorityTwo = FotoDAO::getFotoByProductVariatieIdAndPrioriteit($productvariatie->getProductVariatieId(), 2);
                            $kleurNaam = KleurDAO::getKleurById($productvariatie->getKleurId())->getNaam();
                    ?>
                                <img src="<?php echo $fotoPriorityOne->getLocatieThumb()?>" <?php if(($hitfound && $productvariatie->getProductVariatieId() == $startPvId) || (!$hitfound && $pvIndex == 0)) {echo "class='visible'";}?> data-priority="1" data-color="<?php echo $kleurNaam?>">
                                <img src="<?php echo $fotoPriorityTwo->getLocatieThumb()?>" data-priority="2" data-color="<?php echo $kleurNaam?>">
                    <?php 
                        }
                    ?>
                </div>
                <ul class="colors">
                    <?php
                        foreach ($productvariaties as $pvIndex => $productvariatie){
                            $kleur = KleurDAO::getKleurById($productvariatie->getKleurId());                                    
                    ?>
                            <li <?php if(($hitfound && $productvariatie->getProductVariatieId() == $startPvId) || (!$hitfound && $pvIndex == 0)) {echo "class='current'";}?> data-kleurId="<?php echo $kleur->getKleurId()?>" title="<?php echo $kleur->getNaam()?>"><a href="#" style="background-color: <?php echo $kleur->getKleurCode()?>"><?php echo ucwords($kleur->getNaam())?></a></li>
                    <?php 
                        } 
                    ?>
                </ul>
            </div>
            <h3><?php echo $product->getNaam()?></h3>
            <h4 class="price-small">€<?php echo number_format($product->getPrijsInclBtw(), 2)?></h4>
            <form class="toDetails" action="detail.php" method ="get">
                <input type="hidden" id="productId" name="productId" value="<?php echo $product->getProductId()?>"/>
                <input type="hidden" id="kleurId" name="kleurId" value="<?php echo $productvariaties[0]->getKleurId()?>"/>
                <input type="submit" class="button" value="View item">
            </form>                    
        </li>
    <?php
    }

function isFormulierIngediend() {
        return isset($_GET['postcheck']);
    }
?>