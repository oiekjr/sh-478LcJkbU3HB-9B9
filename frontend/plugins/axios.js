export default function ({ $axios }) {
  $axios.defaults.withXSRFToken = true
}
