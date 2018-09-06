document.addEventListener("keyup",function(e){
	if (e.ctrlKey && e.which == 67){ 
		// console.log("oressed both");
		window.location.href="index.php";
	}
});

var bAmount = document.querySelector("#bAmount");
var bCharge = document.querySelector("#bCharge");
var bGross = document.querySelector("#bGross");
var bTenderCash = document.querySelector("#bTenderCash");
var bBalance = document.querySelector("#bBalance");
var bIncome = document.querySelector("#bIncome");
console.log(bAmount);
bAmount.addEventListener("blur",function(){
	bAmount = this.value;
	// console.log("bamountis"+bAmount);
	bCharge.addEventListener("blur",function(){
		var bCharge = this.value;
			bCharge = Number(bCharge);
			bAmount = Number(bAmount);
		bGross = bAmount+bCharge;
			bGross = Number(bGross);
		updateGross(bGross);
		// console.log("bcharge"+bCharge);
		   bTenderCash.addEventListener("blur",function(){
		   		bTenderCash = this.value;
		   			bTenderCash = Number(bTenderCash);
		   		bBalance = bTenderCash-bGross;
		   		updateBalance(bBalance);
		   		// console.log("btend"+bTenderCash);
		   });
	});	
});
function updateGross(bGross){
	gross=document.querySelector("#bGross");
	gross.value=bGross;
}

function updateBalance(bBalance){
	balance=document.querySelector("#bBalance");
	balance.value=bBalance;
}