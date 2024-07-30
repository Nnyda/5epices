
<?php include("header.php")?>

	<!-- Title Page -->
	<section class="bg-title-page flex-c-m p-t-160 p-b-80 p-l-15 p-r-15" style="background-image: url(images/bg-title-page-02.jpg);">
		<h2 class="tit6 t-center">
		Commande et Livraison
		</h2>
	</section>
	<!-- Formulaire de commande -->
    <section class="bg-white section-booking bg1-pattern p-t-100 p-b-110" style="padding-bottom:50px;padding-top:50px">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 p-b-30">
					<div class="t-center">
						<span class="tit2 t-center">
			  Passer votre 
						</span>
	
						<h3 class="tit3 t-center m-b-35 m-t-2">
			  Commande
						</h3>
					</div>
    <div class="container">
       
		  <form id="wrap-form-booking" class="wrap-form-reservation size22 m-l-r-auto" >
		   <div class="row">
			   <div class="col-md-6">
				   <!-- Repas -->
					   <div class="form-group">
						 <label for="mainCourse" class="txt9">Sélectionnez vos plats :</label>
						 <select id="mainCourse" class="form-control" multiple required>
						   <option value="Pizza Margherita">Pizza - 4000 FCFA</option>
						   <option value="Burger du Chef">Burger - 3000 FCFA</option>
						   <option value="Salade César">Salade - 5000 FCFA</option>
						   <option value="Spaghetti Bolognaise">Spaghetti - 5000 FCFA</option>
						   <option value="Pizza Margherita">Pizza - 4000 FCFA</option>
						   <option value="Burger du Chef">Burger - 3000 FCFA</option>
						   <option value="Salade César">Salade - 5000 FCFA</option>
						   <option value="Spaghetti Bolognaise">Spaghetti - 5000 FCFA</option>
						   <option value="Pizza Margherita">Pizza - 4000 FCFA</option>
						   <option value="Burger du Chef">Burger - 3000 FCFA</option>
						   <option value="Salade César">Salade - 5000 FCFA</option>
						   <option value="Spaghetti Bolognaise">Spaghetti - 5000 FCFA</option>
						   <option value="Pizza Margherita">Pizza - 4000 FCFA</option>
						   <option value="Burger du Chef">Burger - 3000 FCFA</option>
						   <option value="Salade César">Salade - 5000 FCFA</option>
						   <option value="Spaghetti Bolognaise">Spaghetti - 5000 FCFA</option>
						 </select>
					   </div>
					
					   <!-- Mode de livraison -->
					   <div class="form-group">
						 <label for="deliveryMethod" class="txt9">Mode de livraison :</label>
						 <select id="deliveryMethod" class="form-control" required>
						   <option>Sélectionnez</option>
						   <option value="Livraison à Domicile">Livraison à Domicile (1000 FCFA)</option>
						   <option value="Collecte sur Place">Retrait sur Place (sans frais supplémentaires)</option>
						 </select>
						</div>
						
						<!-- Nom du client -->
						<div class="form-group">
						  <label for="fullName" class="txt9">Votre Nom:</label>
						  <input type="text" id="fullName" class="form-control" style="border: 1px solid rgba(0,0,0,.15);" required>
						</div>				 
			   </div>
			   <div class="col-md-6">
				   <!--  Accompagnements et boissons -->
				   <div class="form-group">
					 <label for="mainCourse" class="txt9">Sélectionnez vos boissons :</label>
					 <select id="mainCourse" class="form-control" multiple required>
					   <option value="Pizza Margherita">Pepsi - 1000 FCFA</option>
					   <option value="Burger du Chef">Coca-Cola - 1000 FCFA</option>
					   <option value="Salade César">Monster - 2OOO FCFA</option>
					   <option value="Spaghetti Bolognaise">XXL - 1000 FCFA</option>
					   <option value="Pizza Margherita">Pepsi - 1000 FCFA</option>
					   <option value="Burger du Chef">Coca-Cola - 1000 FCFA</option>
					   <option value="Salade César">Monster - 2OOO FCFA</option>
					   <option value="Spaghetti Bolognaise">XXL - 1000 FCFA</option>
					   <option value="Pizza Margherita">Pepsi - 1000 FCFA</option>
					   <option value="Burger du Chef">Coca-Cola - 1000 FCFA</option>
					   <option value="Salade César">Monster - 2OOO FCFA</option>
					   <option value="Spaghetti Bolognaise">XXL - 1000 FCFA</option>
					 </select>
					</div>
		
					<!-- Lieu de Liviraison -->
					<div class="form-group">
						<!-- Select2 -->
						<label for="mainCourse" class="txt9">Lieu de Livraison :</label>
						<select class="form-control" name="people">
						   <option>Sélectionnez</option>
					   </select>
				   </div>  
				   
				   <!-- Numéro du client -->
				   <div class="form-group">
					 <label for="phone" class="txt9">Numéro de Téléphone :</label>
					 <input type="text" id="phone" class="form-control bd" required>
				   </div>			   
			   </div>

		   </div>

		   <center>
			   <button type="submit" class="btn3 flex-c-m size13 txt11 trans-0-4">Commander</button>
		   </center>

		   <div class="info-reservation" style="padding-top:20px;" >
				<div class="">
				<center>
					<p class="" style="font-size:20px;">
						Vous pouvez également nous appeler au <span class="" style="color:red;">+229 XXXXXX</span>
							passer votre<span class="" style="color:black;font-weight:bold;"> commande.</span>
					</p>
				</center>
				</div>
		   </div>
		  </form>
    </div>


    </section>

  <?php include("footer.php")?>