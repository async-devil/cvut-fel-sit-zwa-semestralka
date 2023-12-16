/**
 * @param {String} url
 * @param {Object} dto
 */
export async function postData(url, dto) {
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(dto),
    });

    const responseData = await response.json();

    return {
      code: response.status,
      data: responseData,
    };
  } catch (error) {
    console.error(error);
  }
}
