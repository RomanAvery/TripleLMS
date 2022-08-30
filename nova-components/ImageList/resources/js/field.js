import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-image-list', IndexField)
  app.component('detail-image-list', DetailField)
  app.component('form-image-list', FormField)
})
