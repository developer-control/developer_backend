  // Initialize Quill editor
  Quill.register('modules/imageUploader', ImageUploader);
  document.addEventListener("DOMContentLoaded", function() {
      const fullToolbarOptions = [
          [{
              header: [1, 2, 3, false]
          }],
          ["bold", "italic"],
          ["clean"],
          [{
              'align': []
          }],
          [{
              'list': 'ordered'
          }, {
              'list': 'bullet'
          }, {
              'list': 'check'
          }],

          ["image"],
      ];

      var quill = new Quill("#quill-editor", {
          theme: "snow",
          modules: {
              toolbar: {
                  container: fullToolbarOptions
              },
              imageUploader: {
                  upload: (file) => {
                      return new Promise((resolve, reject) => {
                          const formData = new FormData();
                          formData.append("image", file);

                          fetch("/store-article-image", {
                                  method: "POST",
                                  body: formData,
                                  headers: {
                                      'X-CSRF-TOKEN': document.querySelector(
                                          'meta[name="csrf-token"]').getAttribute(
                                          'content')
                                  }
                              })
                              .then((response) => response.json())
                              .then((result) => {
                                //   console.log(result);
                                  resolve(result.url);
                              })
                              .catch((error) => {
                                  reject("Upload failed");
                                //   console.error("Error:", error);
                              });
                      });
                  }
              }
          }
      });
      quill.on('text-change', function() {
          console.log(quill.root.innerHTML);
      });
      // console.log(quill);
  });