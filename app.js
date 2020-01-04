var app = new Vue({
	el: "#root",
	data: {
		showingAddModal: false,
		showingEditModal: false,
		showingDeleteModal: false,
		errorMessage:"",
		productionHouses : [],
		movieData:[],
		newProHouse :{id:"",name:""},
		newMovieData:{id:"",movie:"",genre:"",productionhouseid:""},
		editProHouse :{},
		editMovieData:{}
	},

	mounted: function(){
		console.log("mounted");
		this.getAllProductionHouses();
		this.getAllMovie();
	},

	methods: {
		getAllProductionHouses:function(){
			axios.get("http://localhost/MyMovie/movieapi.php?req=read")
			.then(function(response){
				if(response.data.error){
					errorMessage = response.data.error;
				}
				else{
					app.productionHouses = response.data.ph;
				}
			});
		},
		getAllMovie:function(){
			axios.get("http://localhost/MyMovie/movieapi.php?req=readmv")
			.then(function(response){
				if(response.data.error){
					errorMessage = response.data.error;
				}
				else{
					app.movieData = response.data.movie;
				}
			});
		},

		chooseProHouse : function(idpro){
			app.editProHouse = idpro;
		},

		chooseMvData : function(idmv){
			app.editMovieData = idmv;
		},

		saveProHouse : function(){
			var postData = app.toData(app.newProHouse);
			axios.post("http://localhost/MyMovie/movieapi.php?req=insert",postData)
			.then(function(response){
				app.newProHouse ={id: "", name:""};
				if(response.data.error){
					errorMessage = response.data.error;
				}
				else{
					app.getAllProductionHouses();
				}
			});
		},
		saveMovieData : function(){
			var postData = app.toData(app.newMovieData);
			axios.post("http://localhost/MyMovie/movieapi.php?req=insertmv",postData)
			.then(function(response){
				app.newMovieData={id:"",movie:"",genre:"",productionhouseid:""};
				if(response.data.error){
					errorMessage = response.data.error;
				}
				else{
					app.getAllMovie();
				}
			});
		},

		updateProHouse : function(){
			var postData = app.toData(app.editProHouse);
			axios.post("http://localhost/MyMovie/movieapi.php?req=update",postData)
			.then(function(response){
				app.editProHouse ={};
				if(response.data.error){
					errorMessage = response.data.error;
				}
				else{
					app.getAllProductionHouses();
				}
			});
		},

		updateMovieData : function(){
			var postData = app.toData(app.editMovieData);
			axios.post("http://localhost/MyMovie/movieapi.php?req=updatemv",postData)
			.then(function(response){
				app.editMovieData ={};
				if(response.data.error){
					errorMessage = response.data.error;
				}
				else{
					app.getAllMovie();
				}
			});
		},

		delProHouse : function(){
			var postData = app.toData(app.editProHouse);
			axios.post("http://localhost/MyMovie/movieapi.php?req=delete",postData)
			.then(function(response){
				app.editProHouse ={};
				if(response.data.error){
					errorMessage = response.data.error;
				}
				else{
					app.getAllProductionHouses();
				}
			});
		},

		delMovieData : function(){
			var postData = app.toData(app.editMovieData);
			axios.post("http://localhost/MyMovie/movieapi.php?req=deletemv",postData)
			.then(function(response){
				app.editMovieData ={};
				if(response.data.error){
					errorMessage = response.data.error;
				}
				else{
					app.getAllMovie();
				}
			});
		},
		toData : function(obj){
			var fdata = new FormData();
			for(var key in obj){
				fdata.append(key, obj[key]);
			}
			return fdata;
		}
	}
});