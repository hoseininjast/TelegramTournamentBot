import moment from "moment";


export const formatDate = (timestamp) => {
    return moment.unix(timestamp).format("YYYY/MMM/D hh:mm");
};

export const formatMoment = (moment) => {
    return moment.format("YYYY/MMM/D hh:mm");
};

export function redirect(url) {
    window.location.href = url;
}
export function deleteSession(key) {
    $.session.remove(key);
    return;
}

export function setSession(key, value) {
    $.session.set(key, value);
    return;
}

export function ReadSession(key) {
    return $.session.get(key);
}


export const copyContent = async (selectedtext) => {
    try {
        selectedtext = selectedtext.replace(/&amp;/g, '&');
        selectedtext = selectedtext.replace(/\s/g, '');
        await navigator.clipboard.writeText(selectedtext);
        ShowToast("success"," Copied to your clipboard");
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
}

export const ShowToast = (
    Icon = "success",
    Text = "successful",
    Timer = 3000,
    ShowConfirmButton = false,
    Position = "top-end",
    ProgressBar = true
) => {
    const Toast = Swal.mixin({
        toast: true,
        position: Position,
        showConfirmButton: ShowConfirmButton,
        timer: Timer,
        timerProgressBar: ProgressBar,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: Icon,
        title: Text,
    });
};
export const ShowAlert = (
    Icon = "success",
    Text = "successful",
) => {
    Swal.fire({
        icon: Icon,
        text: Text,
    });
};
