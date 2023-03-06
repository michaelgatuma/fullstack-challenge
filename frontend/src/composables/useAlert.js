import swal from "sweetalert";

export function useAlert() {
  function alert(title, message, level = "info") {
    return swal(title, message, level);
  }
  return { alert };
}
