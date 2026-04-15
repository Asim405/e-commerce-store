# TechStore Chatbot - Setup & Usage Guide

## Chatbot Features

✅ **Product Inquiries** - Users can ask about products, prices, specs, warranty
✅ **Order Tracking** - Track orders by Order ID
✅ **Shipping Info** - Delivery information and status
✅ **Warranty & Returns** - Return policies and warranty details
✅ **Payment Methods** - Information about accepted payment options
✅ **General Support** - FAQ and common queries
✅ **Conversation Logging** - All conversations are saved

## Setup Instructions

### Step 1: Initialize Chatbot Database

Open your browser and visit:
```
http://localhost/techstore/setup_chatbot.php
```

This will:
- Create `chatbot_conversations` table (stores all conversations)
- Create `chatbot_kb` table (knowledge base with responses)
- Populate 25+ predefined responses

**Status**: You should see checkmarks (✓) for all items completed.

### Step 2: View Chatbot on About Page

Go to:
```
http://localhost/techstore/about.php
```

You'll see a **chat icon button** ( 💬 ) in the bottom-right corner.

### Step 3: Test the Chatbot

Click the chat button and try asking:

**Product Questions:**
- "Tell me about smart watch"
- "Price of earbuds?"
- "What's the warranty?"
- "Show me laptops"

**Order & Tracking:**
- "Track my order"
- "Order status"
- "Where's my package?"
- "How long is delivery?"

**General:**
- "Hello"
- "Help"
- "Contact us"
- "Payment methods"

## Files Created/Modified

### New Files:
1. **setup_chatbot.php** - Database initialization script
2. **ajax/chatbot.php** - Backend API for chatbot responses
3. **assets/js/chatbot.js** - Frontend chatbot logic
4. **assets/css/chatbot.css** - Chatbot styling

### Modified Files:
1. **about.php** - Added chatbot UI and scripts

## Chatbot Behavior

### How It Works:
1. User types a message
2. System searches knowledge base for matching keywords
3. Returns the best matching response
4. Conversation is logged to database

### Matching System:
- **Keyword Matching**: System finds keywords in messages
- **Priority Scoring**: More specific keywords are prioritized
- **Fallback**: Generic response if no match found

## Customization Options

### Add New Responses:
You can add more responses via phpMyAdmin:

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Go to `techstore` → `chatbot_kb` table
3. Insert new rows with:
   - `keyword`: What users might type
   - `response`: What chatbot should reply
   - `category`: products/orders/support/billing/general
   - `priority`: Higher number = higher priority

**Example:**
```
keyword: "screen size"
response: "Our laptops have 13.3-14 inch screens. What else would you like to know?"
category: "products"
priority: 2
```

### View Conversation Logs:
In phpMyAdmin → `chatbot_conversations` table, you can see:
- User messages
- Bot responses
- Category of query
- Timestamp

## Responsive Design

✓ Works on desktop browsers
✓ Works on mobile (full-screen on small devices)
✓ Smooth animations
✓ Auto-scrolls to new messages

## Features Breakdown

### 1. **Product Responses**
- Headphones, earbuds, smartwatch, laptop, smartphone, camera, tablet, keyboard
- Each includes price, key specs, and warranty

### 2. **Order & Tracking**
- Track order status
- Delivery information
- Shipping costs

### 3. **Support**
- Warranty information
- Return policies
- Refund process

### 4. **Payment**
- Payment method options
- Easypaisa, credit card info

### 5. **General**
- Greetings
- Help/FAQ
- Contact information
- Business hours

## Next Steps (Optional Enhancements)

### Future Improvements:
1. **AI Integration** - Connect to ChatGPT API for smarter responses
2. **Live Chat** - Switch to human support when needed
3. **Admin Panel** - Manage chatbot responses without database access
4. **Analytics** - Track most asked questions, user satisfaction
5. **Multi-language** - Support Urdu, Arabic, etc.
6. **Proactive Messages** - Send greeting based on page/time
7. **Custom Forms** - Collect order info, feedback via chatbot

## Troubleshooting

**Q: Chatbot button not appearing?**
A: Make sure `chatbot.css` and `chatbot.js` are linked in the page

**Q: Chatbot not responding?**
A: Check that `setup_chatbot.php` was run successfully and database tables exist

**Q: Old responses showing?**
A: Clear browser cache (Ctrl+Shift+Delete) or use incognito mode

**Q: Want to add more responses?**
A: Use phpMyAdmin to insert new rows in `chatbot_kb` table

---

## Ready to Use! 🎉

Your TechStore chatbot is now active on the About page. Visitors can:
- Get instant product information
- Track their orders
- Learn about policies
- Ask general questions

All without waiting for human support!
