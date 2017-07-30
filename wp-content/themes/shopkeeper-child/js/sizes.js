
//var $j = jQuery.noConflict();

jQuery(document).ready(function($) {


	var dropdown = document.getElementById('pa_size');
	var dropdownColor = document.getElementById('pa_color');


	// Change on Back-up option change
	dropdown.onchange = function(event){

			jQuery(".size-chart").hide();

			if (dropdown.value == "0-3-month") {

				var rs3m = `
				<div class='size-chart'>
		    		<div class="brand-title">Rabbit Skins</div>
				    <table><thead><tr><th></th><td>0 - 3 Months</td></tr></thead>
				    <tbody><tr><td><strong>Body Length (inches)</strong></td><td>11 1/2</td></tr>
				    <tr><td><strong>Body Width (inches)</strong></td><td>7 1/4</td></tr></tbody></table>
			 	</div>
			`;

				jQuery( ".quantity" ).after( rs3m );

			}


			if (dropdown.value == "3-6m") {

				var aa3to6m = `
				<div class='size-chart'>
		    		<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				    <table><thead><tr><th></th><td>3-6m</td></tr></thead>
				    <tbody><tr><td><strong>Chest (inches)</strong></td><td>14</td></tr>
				    <tr><td><strong>Length (inches)</strong></td><td>17 - 24</td></tr></tbody></table>
			 	</div>
			`;

				jQuery( ".quantity" ).after( aa3to6m );

			}


			if (dropdown.value == "6-12-months") {
				var aa6to12m = `
					<div class='size-chart'>
			    		<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
					    <table><thead><tr><th></th><td>6-12m</td></tr></thead>
					    <tbody><tr><td><strong>Chest (inches)</strong></td><td>16</td></tr>
					    <tr><td><strong>Length (inches)</strong></td><td>25 - 28</td></tr></tbody></table>
				 	</div>
				`;

				jQuery( ".quantity" ).after( aa6to12m );
			}


			if (dropdown.value == "12-18-months" ) {
				var aa12to18m = `
					<div class='size-chart'>
			    		<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
					    <table><thead><tr><th></th><td>12-18m</td></tr></thead>
					    <tbody><tr><td><strong>Chest (inches)</strong></td><td>18</td></tr>
					    <tr><td><strong>Length (inches)</strong></td><td>29 - 31</td></tr></tbody></table>
				 	</div>
				`;

		    	jQuery( ".quantity" ).after( aa12to18m );
			}


		    if ( dropdown.value == "18-24-months" ) {
		    	var aa18to24 = `
					<div class='size-chart'>
			    		<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
					    <table><thead><tr><th></th><td>18-24m</td></tr></thead>
					    <tbody><tr><td><strong>Chest (inches)</strong></td><td>20</td></tr>
					    <tr><td><strong>Length (inches)</strong></td><td>32 - 34</td></tr></tbody></table>
				 	</div>
				`;
				jQuery( ".quantity" ).after( aa18to24 );
			}


			if ( dropdown.value == "2t-3t" ) {
				var aa2t3t = `
					<div class='size-chart'>
			    		<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
						<table><thead><tr><th></th><td>2yrs</td></tr></thead>
						<tbody><tr><td><strong>Height (inches)</strong></td><td>32 - 36</td></tr>
						<tr><td><strong>Chest (inches)</strong></td><td>21</td></tr></tbody></table>
					</div>
				`;
				//jQuery( ".size-chart" ).replaceWith( aa2t3t );
				jQuery( ".quantity" ).after( aa2t3t );
			}


			if ( dropdown.value == "4t" && dropdownColor.value == "black" || dropdown.value == "4t" && dropdownColor.value == "white" ) {
					var anvil4t = `
					<div class='size-chart'>
					<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2017/03/anvil.png"></div>
						<table><thead><tr><th></th><td>XS (2 - 4yrs)</td></tr></thead>
						<tbody><tr><td><strong>Length (inches)	</strong></td><td>21</td></tr>
						<tr><td><strong>Width (inches)</strong></td><td>16</td></tr></tbody></table>
					</div>
				`;
				jQuery( ".quantity" ).after( anvil4t );

			} 	else if ( dropdown.value == "4t" && dropdownColor.value != "black" || dropdown.value == "4t" && dropdownColor.value != "white" ) {

				var aa4t = `
					<div class='size-chart'>
					<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
						<table><thead><tr><th></th><td>4yrs</td></tr></thead>
						<tbody><tr><td><strong>Height (inches)</strong></td><td>36 - 40</td></tr>
						<tr><td><strong>Chest (inches)</strong></td><td>22</td></tr></tbody></table>
					</div>
				`;

				jQuery( ".quantity" ).after( aa4t );
			}



			if ( dropdown.value == "56t" && dropdownColor.value == "black" || dropdown.value == "56t" && dropdownColor.value == "white" ) {

				var anvil6t = `
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2017/03/anvil.png"></div>
					<table><thead><tr><th></th><td>S (6 - 8yrs)</td></tr></thead>
					<tbody><tr><td><strong>Length (inches)	</strong></td><td>22 1/2</td></tr>
					<tr><td><strong>Width (inches)</strong></td><td>17</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( anvil6t );

			} else if ( dropdown.value == "56t" && dropdownColor.value != "black" ||  dropdown.value == "56t" && dropdownColor.value != "white" ) {
				var aa6t = `
					<div class='size-chart'>
					<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
						<table><thead><tr><th></th><td>5-6yrs</td></tr></thead>
						<tbody><tr><td><strong>Height (inches)</strong></td><td>40 - 43</td></tr>
						<tr><td><strong>Chest (inches)</strong></td><td>23</td></tr></tbody></table>
					</div>
				`;

				jQuery( ".quantity" ).after( aa6t );
			}


			if ( dropdown.value == "7-8yrs" ) {

				var aa7to8 =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>8yrs</td></tr></thead>
				<tbody><tr><td><strong>Height (inches)</strong></td><td>48 - 50</td></tr>
				<tr><td><strong>Chest (inches)</strong></td><td>26</td></tr></tbody></table>
				</div>
				`;

				//jQuery( ".size-chart" ).replaceWith( aa7to8 );
				jQuery( ".quantity" ).after( aa7to8 );
			}


			if ( dropdown.value == "9-10yrs" ) {

				var aa9to10 =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>9-10yrs</td></tr></thead>
				<tbody><tr><td><strong>Height (inches)</strong></td><td>51 - 54</td></tr>
				<tr><td><strong>Chest (inches)</strong></td><td>27</td></tr></tbody></table>
				</div>
				`;

				//jQuery( ".size-chart" ).replaceWith( aa9to10 );
				jQuery( ".quantity" ).after( aa9to10 );
			}


			if ( dropdown.value == "11-12yrs" ) {

				var a11to12 =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>12yrs</td></tr></thead>
				<tbody><tr><td><strong>Height (inches)</strong></td><td>55 - 59</td></tr>
				<tr><td><strong>Chest (inches)</strong></td><td>28</td></tr></tbody></table>
				</div>
				`;

				//jQuery( ".size-chart" ).replaceWith( a11to12 );
				jQuery( ".quantity" ).after( a11to12 );
			}


			if ( dropdown.value == "womens-small" ) {

				var womensSmall =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Women's Small</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>30 - 32</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>25 - 26</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( womensSmall );
			}


			if ( dropdown.value == "womens-medium" ) {

				var womensMedium =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Women's Medium</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>32 - 34</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>27 - 28</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( womensMedium );
			}


			if ( dropdown.value == "womens-large" ) {

				var womensLarge =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Women's Large</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>36 - 38</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>30 - 32</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( womensLarge );
			}


			if ( dropdown.value == "womens-x-large" ) {

				var womensXLarge =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Women's XL</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>40 - 42</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>33 - 35</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( womensXLarge );
			}


			if ( dropdown.value == "womens-2xl" ) {

				var womens2XLarge =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Women's 2XL</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>44 - 46</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>36 - 38</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( womens2XLarge );
			}


			if ( dropdown.value == "mens-small" ) {

				var mensSmall =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Men's Small</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>34 - 36</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>30 - 32</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( mensSmall );
			}


			if ( dropdown.value == "mens-medium" ) {

				var mensMedium =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Men's Medium</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>38 - 40</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>32 - 33</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( mensMedium );
			}


			if ( dropdown.value == "mens-large" ) {

				var mensLarge =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Men's Large</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>42 - 44</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>33 - 34</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( mensLarge );
			}


			if ( dropdown.value == "mens-xl" ) {

				var mensXLarge =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Men's XL</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>46 - 48</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>36 - 38</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( mensXLarge );
			}


			if ( dropdown.value == "mens-2xl" ) {

				var mens2XLarge =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Men's 2XL</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>48 - 50</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>40 - 42</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( mens2XLarge );
			}


			if ( dropdown.value == "mens-3xl" ) {

				var mens3XLarge =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Men's 3XL</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>50 - 52</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>44 - 48</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( mens3XLarge );
			}


			if ( dropdown.value == "xs" ) {

				var XSAdult =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>XS (Unisex)</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>30 - 32</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>28 - 30</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( XSAdult );
			}


			if ( dropdown.value == "s" ) {

				var SAdult =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Small (Unisex)</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>34 - 36</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>30 - 32</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( SAdult );
			}


			if ( dropdown.value == "m" ) {

				var MAdult =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Medium (Unisex)</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>38 - 40</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>32 - 33</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( MAdult );
			}


			if ( dropdown.value == "l" ) {

				var LAdult =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>Large (Unisex)</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>42 - 44</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>33 - 34</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( LAdult );
			}


			if ( dropdown.value == "xl" ) {

				var XLAdult =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>X-Large (Unisex)</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>46 - 48</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>36 - 38</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( XLAdult );
			}


			if ( dropdown.value == "2xl" ) {

				var XXLAdult =`
				<div class='size-chart'>
				<div class="brand-title"><img src="https://www.diggityjr.com/wp-content/uploads/2015/05/american_apparel_logo.jpg"></div>
				<table><thead><tr><th></th><td>2XL (Unisex)</td></tr></thead>
				<tbody><tr><td><strong>Chest (inches)</strong></td><td>48 - 50</td></tr>
				<tr><td><strong>Waist (inches)</strong></td><td>40 - 42</td></tr></tbody></table>
				</div>
				`;

				jQuery( ".quantity" ).after( XXLAdult );
			}

			var pathname = window.location.pathname; // Returns path only

			if  (/sweater/.test(pathname) || /tank/.test(pathname)) {
				$( ".size-chart" ).hide();
			}


		}//Drop-down change
}); //jQuery end
