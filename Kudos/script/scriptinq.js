const inqContainer = document.getElementById("inquiries");

fetch('data/inq.json')
  .then(response => response.json())
  .then(data => {
    data.forEach(inquiry => {
      const card = document.createElement("div");
      card.className = "card col-sm-3";

      const cardHeader = document.createElement("div");
      cardHeader.className = "card-header";
      cardHeader.textContent = inquiry.header;

      const cardBody = document.createElement("div");
      cardBody.className = "card-body";

      const blockContent = document.createElement("blockquote");
      blockContent.className = "blockContent mb-0";

      const messageBody = document.createElement("p");
      messageBody.textContent = inquiry.message_body;

      const writerName = document.createElement("span");
      writerName.className = "blockContent-footer";
      writerName.textContent = inquiry.writer_name;

      blockContent.appendChild(messageBody);
      blockContent.appendChild(writerName);

      cardBody.appendChild(blockContent);

      card.appendChild(cardHeader);
      card.appendChild(cardBody);

      inqContainer.appendChild(card);
    });
  })
  .catch(error => console.error('Error loading inquiries:', error));
