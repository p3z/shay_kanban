
class PwsHtmlBuilder{
        
    static set_attributes(el, attrs) {
        Object.keys(attrs).forEach(key => el.setAttribute(key, attrs[key]));
    }
    
    static create_elements( el_type, class_list = [], qty = 1 ){
       
        let return_arr = [];
        
        for(let i = 0; i < qty; i++){
            
            let el = document.createElement( el_type );
            el.classList.add( ...class_list ); // 'Spread' the list into the classList
            return_arr.push(el);
        } // end loop
        
        return return_arr;
    }
} // end class