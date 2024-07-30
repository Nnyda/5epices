<?php include("header.php")?>

	<!-- Title Page -->
	<section class="bg-title-page flex-c-m p-t-160 p-b-80 p-l-15 p-r-15" style="background-image: url(images/bg-title-page-02.jpg);">
		<h2 class="tit6 t-center">
			Reservation / evenement
		</h2>
	</section>


	<!-- Reservation -->
	<section class="section-reservation bg1-pattern p-t-100 p-b-113">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 p-b-30">
					<div class="t-center">
						<span class="tit2 t-center">
							Reservation
						</span>

						<h3 class="tit3 t-center m-b-35 m-t-2">
							de table
						</h3>
					</div>

					<form class="wrap-form-reservation size22 m-l-r-auto">
						<div class="row">
							<div class="col-md-4">
								<!-- Date -->
								<span class="txt9">
									Date
								</span>

								<div class="wrap-inputdate pos-relative txt10 size12 bo2 bo-rad-10 m-t-3 m-b-23">
								    <input class="my-calendar bo-rad-10 sizefull txt10 p-l-20" type="text" name="date">
									<i class="btn-calendar fa fa-calendar ab-r-m hov-pointer m-r-18" aria-hidden="true"></i>
								</div>
							</div>

							<div class="col-md-4">
								<!-- Time -->
								<span class="txt9">
									Heure
								</span>

								<div class="wrap-inputtime size12 bo2 bo-rad-10 m-t-3 m-b-23">
								<input class="bo-rad-10 sizefull txt10 p-l-20" type="time" min="08:00" max="00:00" name="time">
								</div>
							</div>

							<div class="col-md-4">
								<!-- People -->
								<span class="txt9">
									Personnes(s)
								</span>

								<div class="wrap-inputpeople size12 bo2 bo-rad-10 m-t-3 m-b-23">
									<!-- Select2 -->
									<select class="selection-1" name="people">
										<option>Une personne</option>
										<option>2 personnes</option>
										<option>3 personnes</option>
										<option>4 personnes</option>
										<option>5 personnes</option>
										<option>6 personnes</option>
										<option>7 personnes</option>
										<option>8 personnes</option>
										<option>9 personnes</option>
										<option>10 personnes</option>
										<option>11 personnes</option>
										<option>12 personnes</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<!-- Name -->
								<span class="txt9">
									Nom
								</span>

								<div class="wrap-inputname size12 bo2 bo-rad-10 m-t-3 m-b-23">
								     <input class="bo-rad-10 sizefull txt10 p-l-20" type="text" name="Nom" placeholder="Nom">
								</div>
							</div>

							<div class="col-md-4">
								<!-- Phone -->
								<span class="txt9">
									Téléphone
								</span>

								<div class="wrap-inputphone size12 bo2 bo-rad-10 m-t-3 m-b-23">
								     <input class="bo-rad-10 sizefull txt10 p-l-20" type="text" name="Téléphone" placeholder="Téléphone">
								</div>
							</div>

							<div class="col-md-4">
								<!-- Email -->
								<span class="txt9">
									Email
								</span>

								<div class="wrap-inputemail size12 bo2 bo-rad-10 m-t-3 m-b-23">
							    	<input class="bo-rad-10 sizefull txt10 p-l-20" type="text" name="email" placeholder="Email">
								</div>
							</div>

						</div>

						<div class="wrap-btn-booking flex-c-m m-t-6">
							<!-- Button3 -->
							<button type="submit" class="btn3 flex-c-m size13 txt11 trans-0-4">
								Reserver
							</button>
						</div>
						<br>
						<br>
						<br>
						<div>
							<center>
								<p class="" style="font-size:20px;">
									Vous pouvez également nous appeler au <span class="" style="color:red;">+229 XXXXXX</span>
									 pour réserver votre <span class="" style="color:black;font-weight:bold;">table.</span> ou pour 
									 réserver pour un <span class="" style="color:black;font-weight:bold;">évènement.</span>
								</p>
							</center>
						</div>
					</form>
				</div>
			</div>
			</div>
		</div>
	</section>


	<?php include("footer.php") ?>