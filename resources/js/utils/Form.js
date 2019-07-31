import Errors from './Errors';
import axios from 'axios';

class Form {
    constructor(data) {
        for (let field in data) {
            this[field] = data[field];
        }
        this.originalData = data;
        this.errors = new Errors();
    }

    data() {
        let data = {};
        for (let field in this.originalData) {
            data[field] = this[field];
        }
        return data;
    }

    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }
        this.errors.clear();
    }

    get(url) {
        let params = [];
        let data = this.data();
        for (let field in data) {
            let str = field + '=' + data[field];
            params.push(str);
        }
        let query = params.join('&');
        let uri = url + '?' + query;
        //console.log(uri);
        return axios.get(uri);
    }

    post(url) {
        return axios.post(url, this.data());
    }

    put(url) {
        return axios.put(url, this.data());
    }

    patch(url) {
        return axios.patch(url, this.data());
    }
}

export default Form;
