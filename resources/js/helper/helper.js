import moment from "moment";
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

export function useToastr() {
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;
    toastr.options.progressBar = true;
    return toastr;
}

export function formatDate(value) {
    if (value) {
        return moment(String(value)).format('YYYY-MM-DD');
    }
}
