export default  class until {
	static uuid() {

		// Retorna um número randômico entre 0 e 15.
		function randomDigit() {
		
			// Se o browser tiver suporte às bibliotecas de criptografia, utilize-as;
			if (crypto && crypto.getRandomValues) {
			
				// Cria um array contendo 1 byte:
				var rands = new Uint8Array(1);
				
				// Popula o array com valores randômicos
				crypto.getRandomValues(rands);
				
				// Retorna o módulo 16 do único valor presente (%16) em formato hexadecimal
				return (rands[0] % 16).toString(16);
			} else {
			// Caso não, utilize random(), que pode ocasionar em colisões (mesmos valores
			// gerados mais frequentemente):
				return ((Math.random() * 16) | 0).toString(16);
			}
		}
		
		// A função pode utilizar a biblioteca de criptografia padrão, ou
		// msCrypto se utilizando um browser da Microsoft anterior à integração.
		var crypto = window.crypto || window.msCrypto;
		
		// para cada caracter [x] na string abaixo um valor hexadecimal é gerado via
		// replace:
		return 'xxxxxxxx-xxxx-4xxx-8xxx-xxxxxxxxxxxx'.replace(/x/g, randomDigit);
	}
	static isInt(val){
		try{
			parseInt(val, 10)
			return true;
		}
		catch(e){
			return false;
		}
	}
	static isEmpty(val){
		return (val == '' || val === undefined || val == null || val.length <= 0) ? true : false;
	}
	static arrayAllElementsIsEmpy(array){
		var count=0
		array.forEach((element,index) => {
			if(this.isEmpty(element)){
				count=count+1;
			}
		});
		return (count===array.length);
	}
	static formatMoney(val){
		return "R$ "+parseFloat(val).toFixed(2).replace('.',',');
	}
	static usernameIsValid(userName) {
		/*start whith letter accept only letter and number */
		var re = /[^\s]\w\w[^\s]+/||/[^\s]\w\d[^\s]+/g;
		return re.test(userName);
	}
	static lowerCaseOneOrMore(text){
		var re = /[a-z]+/;
        return re.test(text);
	}
	static upperCaseOneOrMore(text){
		var re = /[A-Z]+/;
        return re.test(text);
	}
	static numberOneOrMore(text){
		var re = /[0-9]+/;
        return re.test(text);
	}
	static emailIsValid(email){
		var re = /\S+@\S+\.\S+/;
        return re.test(email);
	}
	static phoneIsValid(phone){
		var re = /\([0-9]{2,2}\)\s[0-9]{4,5}-?[0-9]{4}/g;
        return re.test(phone);
	}
	static zipCodeBrasilianIsValid(phone){
		var re = /[0-9]{5}-?[0-9]{3}/g;
        return re.test(phone);
	}

	static passwordIsValid(password){
		/*one or more number, one or more letter lower case and uppercase with 8 digits or more*/
		var re = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8})$/;
        return re.test(password);
	}
	static utf8Tounicode(s){
		const caracters={
			"\\u00e1":"á",
			"\\u00e0":"à",
			"\\u00e2":"â",
			"\\u00e3":"ã",
			"\\u00e4":"ä",
			"\\u00c1":"Á",
			"\\u00c0":"À",
			"\\u00c2":"Â",
			"\\u00c3":"Ã",
			"\\u00c4":"Ä",
			"\\u00e9":"é",
			"\\u00e8":"è",
			"\\u00ea":"ê",
			"\\u00ea":"ê",
			"\\u00c9":"É",
			"\\u00c8":"È",
			"\\u00ca":"Ê",
			"\\u00cb":"Ë",
			"\\u00ed":"í",
			"\\u00ec":"ì",
			"\\u00ee":"î",
			"\\u00ef":"ï",
			"\\u00cd":"Í",
			"\\u00cc":"Ì",
			"\\u00ce":"Î",
			"\\u00cf":"Ï",
			"\\u00f3":"ó",
			"\\u00f2":"ò",
			"\\u00f4":"ô",
			"\\u00f5":"õ",
			"\\u00f6":"ö",
			"\\u00d3":"Ó",
			"\\u00d2":"Ò",
			"\\u00d4":"Ô",
			"\\u00d5":"Õ",
			"\\u00d6":"Ö",
			"\\u00fa":"ú",
			"\\u00f9":"ù",
			"\\u00fb":"û",
			"\\u00fc":"ü",
			"\\u00da":"Ú",
			"\\u00d9":"Ù",
			"\\u00db":"Û",
			"\\u00e7":"ç",
			"\\u00c7":"Ç",
			"\\u00f1":"ñ",
			"\\u00d1":"Ñ",
			"\\u0026":"&",
			"\\u0027":"'"
		};
		Object.entries(caracters).forEach(([key, value]) => {
			if (typeof s === 'string' || s instanceof String)
			{
					s=s.replace(key,value);
			}
		});
		return s;
	}
	static ObjUtf8Tounicode(obj){
		Object.entries(obj).forEach(([key, value])  => {
			 obj[key]=until.utf8Tounicode(value);
		 }); 
		 return obj;
	 }
	 static ArrayObjUtf8Tounicode(array){
		if (	
			!until.isEmpty(array)
			&& Array.isArray(array)
			&& array.length >0
		)
		{
			array.forEach((item, index) =>{
			array[index]=until.ObjUtf8Tounicode(item);
			});
		}	
		 return array;
	 }
	 static toFormData(obj) {
		var fd = new FormData();
		for (var key in obj) {
			var value =obj[key];
			fd.append(key, value);
		}
		return fd;
	}
}